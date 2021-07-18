<?php
class Form
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $form->set("id", "");
    $form->set("pessoa", ""); p
    $form->set("site", ""); d
    $form->set("descricao", ""); i
    $retorno["msg"] = $form->saida(); m
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["pessoa"]) && isset($_POST["site"]) && isset($_POST["descricao"])) {
      try {
        $conexao = Transaction::get();
        $paciente = $conexao->quote($_POST["paciente"]);
        $diag = $conexao->quote($_POST["diag"]);
        $idade = $conexao->quote($_POST["idade"]);
        $crud = new Crud();
        if (empty($_POST["id"])) {
          $retorno = $crud->insert(
            "consultorio",
            "paciente,diag,idade",
            "{$paciente},{$diag},{$idade}"
          );
        } else {
          $id = $conexao->quote($_POST["id"]);
          $retorno = $crud->update(
            "consultorio",
            "paciente={$paciente}, diag={$diag}, idade={$idade}",
            "id={$id}"
          );
        }
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}