<?php
class Template
{
  private $arquivo;
  private $valores = array();

  public function __construct($arquivo)
  {
    $this->arquivo = $arquivo;
  }

  public function set($chave, $valor)
  {
    $this->valores[$chave] = $valor;
  }

  public function saida()
  {
    if (!file_exists($this->arquivo)) {
      return "Erro ao carregar Template";
    } else {
      $saida = file_get_contents($this->arquivo);
      if (count($this->valores) > 0) {
        foreach ($this->valores as $chave => $valor) {
          if (is_array($valor)) {
            $saida = $this->trecho($saida, $chave, $valor);
          } else {
            $tag = "{{$chave}}";
            $saida = str_replace($tag, $valor, $saida);
          }
        }
      }
      return $saida;
    }
  }

  private function trecho($saida, $chave, $valor)
  {
    // Geral
    $inicioGeral = strstr($saida, "{{$chave}}", TRUE);
    $fimGeral = strstr($saida, "{/{$chave}}");
    $fimGeral = str_replace("{/{$chave}}", "", $fimGeral);
    // Trecho
    $inicioTrecho = strstr($saida, "{{$chave}}");
    $pedaco = strstr($inicioTrecho, "{/{$chave}}", TRUE);
    $pedaco = str_replace("{{$chave}}", "", $pedaco);
    // Substituir
    $saidaTrecho = "";
    foreach ($valor as $indiceFora => $valorFora) {
      $pedacoTrecho = $pedaco;
      foreach ($valorFora as $indiceDentro => $valorDentro) {
        $tag = "{{$indiceDentro}}";
        $pedacoTrecho = str_replace($tag, $valorDentro, $pedacoTrecho);
      }
      $saidaTrecho .= $pedacoTrecho;
    }
    $saida = $inicioGeral . $saidaTrecho . $fimGeral;
    return $saida;
  }
}
© 2021 GitHub, Inc.