<?php namespace App\Mamarrachismo;

use Auth;
use Mail;
use App\User;

/**
 * https://github.com/slayerfat/sistemaCONDOR/blob/master/app/Http/Controllers/Otros/EnviarEmail.php
 */
class EnviarEmail {

  /**
   * la bolsa de correos a ser enviados.
   * @var array
   */
  protected $emails = [];

  // --------------------------------------------------------------------------
  // Funciones Publicas
  // --------------------------------------------------------------------------

  public function getAdministratorsEmail()
  {
    // se buscan los administradores
    $models = User::admins()->get();
    $this->iterateModels($models);

    return $this->emails;
  }

  public function getAllUsersEmail()
  {
    // se buscan los administradores
    $models = User::admins()->get();
    $this->iterateModels($models);

    return $this->emails;
  }

  // --------------------------------------------------------------------------
  // Funciones Privadas
  // --------------------------------------------------------------------------
  private function iterateModels($models)
  {
    // logica simplificada por ahora.
    // ver: https://github.com/slayerfat/sistemaCONDOR/blob/master/app/Http/Controllers/Otros/EnviarEmail.php#L27
    foreach ($models as $model) :
      if ($model->email){ $this->emails[] = $model->email; }
    endforeach;

    return $this->emails;
  }

  // --------------------------------------------------------------------------
  // Funciones Estaticas
  // --------------------------------------------------------------------------

  /**
   * version simplificada
   *
   * @return array
   */
  static function getAdminsEmail()
  {
    $obj = new self;

    return $obj->getAdministratorsEmail();
  }

  /**
   * version simplificada
   *
   * @return array
   */
  static function getUsersEmail()
  {
    $obj = new self;

    return $obj->getAdministratorsEmail();
  }
  /**
   * Se envia los correos deseados. TEP.
   *
   * @todo ajustarlo a este app.
   *
   * @param  array    $data  el array con los datos relacionados
   * @return boolean
   */
  static function enviarEmail($data, $emails)
  {
    // por si acaso...
    if (!isset($data) and !isset($emails)) return null;
    Mail::send($data['vista'], $data, function($message) use ($emails, $data){
      $message->to($emails)->subject($data['subject']);
    });
    return true;
  }
}