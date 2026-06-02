<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Estoque — alerta de quantidade baixa
  |--------------------------------------------------------------------------
  |
  | Usado quando o item não define quantidade_minima própria.
  |
  */

  'estoque_limite_padrao' => (int) env('ESTOQUE_LIMITE_BAIXO', 10),

  /*
  |--------------------------------------------------------------------------
  | E-mail administrativo (cópia opcional)
  |--------------------------------------------------------------------------
  */

  'email_admin' => env('NOTIFICACAO_EMAIL_ADMIN'),

];
