<?php

namespace App\Http\Controllers;

use App\Models\Musica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class MusicaController extends Controller
{
    /**
     * Lista todas as músicas cadastradas.
     */
    public function index()
    {
        return response()->json(Musica::all(), 200);
    }

    /**
     * Armazena uma nova música.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'url' => 'required|url'
            ]);

            $videoId = $this->extractVideoId($request->url);
            if (!$videoId) {
                throw new \Exception('URL inválida ou vídeo não encontrado.');
            }

          
            $videoInfo = $this->getVideoInfo($videoId);

           
            $user = Auth::user();
            $status = ($user && $user->role === 'admin') ? 'aprovado' : 'pendente';

            $musica = Musica::updateOrCreate(
                ['youtube_id' => $videoId],
                array_merge($videoInfo, ['status' => $status])
            );

            return response()->json([
                'message' => 'Música adicionada com sucesso!',
                'musica' => $musica
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Erro ao adicionar música: ' . $e->getMessage());

            return response()->json(['error' => 'Erro ao adicionar música: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pendente,aprovado'
        ]);

        $musica = Musica::findOrFail($id);
        $musica->status = $request->status;
        $musica->save();

        return response()->json(['message' => 'Status atualizado!', 'musica' => $musica]);
    }


    /**
     * Extrai o ID do vídeo do YouTube a partir da URL.
     */
    private function extractVideoId($url)
    {
        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([^&?\/]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Obtém informações do vídeo via web scraping (sem API Key).
     */
    private function getVideoInfo($videoId)
    {
        $url = "https://www.youtube.com/watch?v=" . $videoId;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
        ]);

     
        $response = curl_exec($ch);
        if ($response === false) {
            throw new \Exception("Erro ao acessar o YouTube: " . curl_error($ch));
        }
        curl_close($ch);

       
        if (!preg_match('/<title>(.+?) - YouTube<\/title>/', $response, $titleMatches)) {
            throw new \Exception("Não foi possível encontrar o título do vídeo");
        }
        $title = html_entity_decode($titleMatches[1], ENT_QUOTES);

     
        if (preg_match('/"viewCount":\s*"(\d+)"/', $response, $viewMatches)) {
            $views = (int)$viewMatches[1];
        } else {
            $views = 0;
        }

        return [
            'titulo' => $title,
            'visualizacoes' => $views,
            'youtube_id' => $videoId,
            'thumb' => "https://img.youtube.com/vi/$videoId/hqdefault.jpg"
        ];
    }

    /**
     * Exibe uma música específica pelo ID.
     */
    public function show($id)
    {
        $musica = Musica::find($id);

        if (!$musica) {
            return response()->json(['error' => 'Música não encontrada'], 404);
        }

        return response()->json($musica, 200);
    }

    /**
     * Atualiza uma música existente.
     */
    public function update(Request $request, $id)
    {
        $musica = Musica::find($id);
        
        if (!$musica) {
            return response()->json(['error' => 'Música não encontrada'], 404);
        }

        $request->validate([
            'url' => 'required|url'
        ]);

        
        $videoId = $this->extractVideoId($request->url);
        if (!$videoId) {
            return response()->json(['error' => 'URL inválida.'], 400);
        }

       
        $videoInfo = $this->getVideoInfo($videoId);

      
        $musica->youtube_id = $videoId;
        $musica->titulo = $videoInfo['titulo'];
        $musica->thumb = $videoInfo['thumb'];
        $musica->visualizacoes = $videoInfo['visualizacoes'];
        $musica->save();

        return response()->json([
            'message' => 'Música atualizada com sucesso!',
            'musica' => $musica
        ]);
    }


    /**
     * Remove uma música do banco de dados.
     */
    public function destroy($id)
    {
        $musica = Musica::find($id);

        if (!$musica) {
            return response()->json(['error' => 'Música não encontrada'], 404);
        }

        $musica->delete();

        return response()->json(['message' => 'Música deletada com sucesso!']);
    }
}
