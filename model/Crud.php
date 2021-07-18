<?php
class Crud
{
  public function __construct()
  {
  }

  public function select($tabela = NULL, $campos = "*", $condicao = NULL)
  {
    try {
      if (!$tabela) {
        $retorno["msg"] = "Faltando parâmetro!";
        $retorno["erro"] = TRUE;
      } else {
        $conexao = Transaction::get();
        if (!$condicao) {
          $sql = "SELECT {$campos} FROM {$tabela}";
        } else {
          $sql = "SELECT {$campos} FROM {$tabela} WHERE {$condicao}";
        }
        $resultado = $conexao->query($sql);
        if ($resultado->rowCount() > 0) {
          while ($dados = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $linhas[] = $dados;
          }
          $retorno["msg"] = $linhas;
          $retorno["erro"] = FALSE;
        } else {
          $retorno["msg"] = "Nenhum registro encontrado!";
          $retorno["erro"] = TRUE;
        }
      }
    } catch (Exception $ex) {
      $retorno["msg"] = "Ocorreu um erro! " . $ex->getMessage();
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function insert($tabela = NULL, $campos = NULL, $valores = NULL)
  {
    try {
      if ($tabela && $campos && $valores) {
        $conexao = Transaction::get();
        $sql = "INSERT INTO {$tabela} ({$campos}) VALUES ({$valores}) ";
        $resultado = $conexao->query($sql);
        if ($resultado->rowCount() > 0) {
          $retorno["msg"] = "Inserido com sucesso!!!";
          $retorno["erro"] = FALSE;
          $retorno["id"] = $conexao->lastInsertId();
        } else {
          $retorno["erro"] = TRUE;
          $retorno["msg"] = "Nenhum registro inserido!";
        }
      } else {
        $retorno["msg"] = "Faltando parâmetro!";
        $retorno["erro"] = TRUE;
      }
    } catch (Exception $ex) {
      $retorno["msg"] = "Ocorreu um erro! " . $ex->getMessage();
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function update($tabela = NULL, $valores = NULL, $condicao = NULL)
  {
    try {
      if ($tabela && $valores && $condicao) {
        $conexao = Transaction::get();
        $sql = "UPDATE {$tabela} SET {$valores} WHERE {$condicao} ";
        $resultado = $conexao->query($sql);
        if ($resultado->rowCount() > 0) {
          $retorno["msg"] = "Atualizado com sucesso!!!";
          $retorno["erro"] = FALSE;
        } else {
          $retorno["erro"] = TRUE;
          $retorno["msg"] = "Nenhum registro atualizado!";
        }
      } else {
        $retorno["msg"] = "Faltando parâmetro!";
        $retorno["erro"] = TRUE;
      }
    } catch (Exception $ex) {
      $retorno["msg"] = "Ocorreu um erro! " . $ex->getMessage();
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function delete($tabela = NULL, $condicao = NULL)
  {
    try {
      if ($tabela && $condicao) {
        $conexao = Transaction::get();
        $sql = "DELETE FROM {$tabela} WHERE {$condicao} ";
        $resultado = $conexao->query($sql);
        if ($resultado->rowCount() > 0) {
          $retorno["msg"] = "Apagado com sucesso!!!";
          $retorno["erro"] = FALSE;
        } else {
          $retorno["erro"] = TRUE;
          $retorno["msg"] = "Nenhum registro apagado!";
        }
      } else {
        $retorno["msg"] = "Faltando parâmetro!";
        $retorno["erro"] = TRUE;
      }
    } catch (Exception $ex) {
      $retorno["erro"] = TRUE;
      $retorno["msg"] = "Ocorreu um erro! " . $ex->getMessage();
    }
    return $retorno;
  }
}