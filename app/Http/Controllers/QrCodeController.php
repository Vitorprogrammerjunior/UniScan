<?php

namespace App\Http\Controllers;

use App\Models\Patrimonio;
use Illuminate\Http\Request;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QrCodeController extends Controller
{
    public function index()
    {
        // Pegar o maior código existente e calcular o próximo
        $ultimoPatrimonio = Patrimonio::orderByRaw('CAST(codigo_barra AS UNSIGNED) DESC')->first();
        $proximoNumero = $ultimoPatrimonio ? (intval($ultimoPatrimonio->codigo_barra) + 1) : 1;
        $proximoCodigo = str_pad($proximoNumero, 6, '0', STR_PAD_LEFT);
        
        return view('admin.qrcodes.index', compact('proximoCodigo'));
    }

    // Lista QR codes pendentes (não cadastrados)
    public function pendentes()
    {
        $patrimonios = Patrimonio::where('cadastrado', false)
            ->orderBy('codigo_barra')
            ->paginate(20);

        return view('admin.qrcodes.pendentes', compact('patrimonios'));
    }

    public function gerar(Request $request)
    {
        $validated = $request->validate([
            'quantidade' => 'required|integer|min:1|max:100',
        ]);

        $quantidade = $validated['quantidade'];
        
        // Pegar o maior código existente
        $ultimoPatrimonio = Patrimonio::orderByRaw('CAST(codigo_barra AS UNSIGNED) DESC')->first();
        $proximoNumero = $ultimoPatrimonio ? (intval($ultimoPatrimonio->codigo_barra) + 1) : 1;

        $qrcodes = [];
        $criados = 0;

        for ($i = 0; $i < $quantidade; $i++) {
            $numero = $proximoNumero + $i;
            $codigo = str_pad($numero, 6, '0', STR_PAD_LEFT);
            
            // Criar patrimônio "fantasma" (pendente de cadastro)
            $patrimonio = Patrimonio::create([
                'codigo_barra' => $codigo,
                'cadastrado' => false,
            ]);
            $criados++;
            
            $qrcodes[] = [
                'codigo' => $codigo,
                'patrimonio' => $patrimonio,
            ];
        }

        $existentes = 0;
        return view('admin.qrcodes.resultado', compact('qrcodes', 'criados', 'existentes'));
    }

    // Imprimir QR codes selecionados
    public function imprimir(Request $request)
    {
        $validated = $request->validate([
            'codigos' => 'required|array',
            'codigos.*' => 'string',
        ]);

        $qrcodes = [];
        
        foreach ($validated['codigos'] as $codigo) {
            $patrimonio = Patrimonio::where('codigo_barra', $codigo)->first();
            if ($patrimonio) {
                $qrcodes[] = [
                    'codigo' => $codigo,
                    'patrimonio' => $patrimonio,
                ];
            }
        }

        $criados = 0;
        $existentes = count($qrcodes);

        return view('admin.qrcodes.resultado', compact('qrcodes', 'criados', 'existentes'));
    }

    public function gerarUnico($codigo)
    {
        // Validar que o código é numérico e tem no máximo 10 dígitos
        if (!preg_match('/^\d{1,10}$/', $codigo)) {
            abort(404);
        }
        
        $baseUrl = config('app.url') . '/patrimonio/';
        $url = $baseUrl . $codigo;

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_M,
            'addQuietzone' => true,
            'quietzoneSize' => 2,
            'outputBase64' => false,
        ]);

        $qr = new QRCode($options);
        $svg = $qr->render($url);

        return response($svg)->header('Content-Type', 'image/svg+xml');
    }
}
