<?php
/*
Plugin Name: Chopy Shop
Plugin URI: http://estebanvc.drawcoders.net/2010/04/04/chopy-shop-paypal-plugin-for-wordpress/
Version: 1.0.1
Author: Esteban Vaquero Cruz
Description: Paypal Shopping Cart for Wordpress
*/

/* Instalacion */

   if(!headers_sent()){ @session_start(); }
   
   /*Directorios raiz*/
   define('CHOPYSHOP_DIR', dirname(plugin_basename(__FILE__)));
   define('CHOPYSHOP_URL', get_option('siteurl').'/wp-content/plugins/'.CHOPYSHOP_DIR);
   
   function config_general(){
      $datos = array( 'paypal_email' => get_option('admin_email'),
                      'simbolo_compra' => '$',
                      'divisa' => 'USD',
                      'lenguaje' => 'en',
                      'cc_vacio' => 'Your Shopping Cart is empty!',
                      'bc_titulo' => 'Buy Now!',
                      'bc_titulo_cc' => 'Continue Shopping',
                      'bc_pedido' => 'Chekout !!',
                      'bc_actualizar' => 'Update Cart',
                      'cc_producto_text' => 'Item',
                      'cc_cantidad_text' => 'Quantity',
                      'cc_precio_text' => 'Amount',
                      'cc_total_text' => 'Total',
                      'url_ok' => get_option('siteurl'),
                      'url_error' => '',
                      'cc_url' => '',
                    );
      return $datos;
   }

   function instalar_datos_default(){
      global $chopy_shop_config;
      if( !empty( $chopy_shop_config ) ){
         foreach( $chopy_shop_config as $key => $valor ){
            if( get_option($key) == ""){
              add_option($key,$valor);
            }
         }
      }
   }
   
   
/* Administracion */
   function opciones_chopyshop(){
     global $chopy_shop_config;
     
     /*Guardar Opciones*/
     if( isset( $_POST['guardar_cambios'] ) ){
        if( !empty( $chopy_shop_config ) ){
           foreach( $chopy_shop_config as $key => $valor){
              update_option($key, $_POST[$key]);
           }
        }
     }
     
     /*Obtener Opciones*/
     if( !empty( $chopy_shop_config ) ){
        foreach( $chopy_shop_config as $key => $valor){
           $CONFIG_G[ $key ] = @htmlspecialchars(get_option($key),ENT_QUOTES);
        }
     }

     echo '<style type="text/css">
          #buy_me_a_beer_banner {
             position:relative;
             width:522px;
             height:148px;
             font-size:90%;

          }
          #buy_me_a_beer_banner a{
             text-decoration:none;
          }
          #buy-me-a-beer-01 {
             position:absolute;
             left:0px;
             top:0px;
             width:25px;
             height:148px;
             background:transparent url('.CHOPYSHOP_URL.'/img/buy-me-a-beer_01.gif) no-repeat;
          }
          #buy-me-a-beer-02 {
             position:absolute;
             left:25px;
             top:0px;
             width:471px;
             height:55px;
             background:transparent url('.CHOPYSHOP_URL.'/img/buy-me-a-beer_02.gif) no-repeat;
          }
          #buy-me-a-beer-03 {
             position:absolute;
             left:496px;
             top:0px;
             width:26px;
             height:148px;
             background:transparent url('.CHOPYSHOP_URL.'/img/buy-me-a-beer_03.gif) no-repeat;
          }
          #buy-me-a-beer-04 {
             position:absolute;
             left:25px;
             top:55px;
             width:471px;
             height:55px;
             background:transparent url('.CHOPYSHOP_URL.'/img/buy-me-a-beer_04.gif) no-repeat;
          }
          #buy-me-a-beer-05 {
             position:absolute;
             left:25px;
             top:110px;
             width:471px;
             height:38px;
             background:transparent url('.CHOPYSHOP_URL.'/img/buy-me-a-beer_05.gif) no-repeat;
          }
          </style>';
           
     echo '<div class="wrap"><h2>Chopy Shop [ General Settings ]</h2>';
     echo '<div id="poststuff"><div id="post-body">';
     echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="donate_paypal_b">
     <input type="hidden" name="cmd" value="_xclick">
     <input type="hidden" name="business" value="E8285RBDPXTAC">
     <input type="hidden" name="lc" value="MX">
     <input type="hidden" name="item_name" value="Suggested: $3.00  a beer or $7.50 for a pitcher">
     <input type="hidden" name="currency_code" value="USD">
     <input type="hidden" name="button_subtype" value="products">
     <input type="hidden" name="cn" value="Añadir instrucciones especiales para el vendedor">
     <input type="hidden" name="no_shipping" value="1">
     <input type="hidden" name="undefined_quantity" value="1">
     </form>';
     
     echo '
     <div id="buy_me_a_beer_banner">
     <div id="buy-me-a-beer-01"></div>
     <div id="buy-me-a-beer-02"></div>
     <div id="buy-me-a-beer-03"></div>
     <div id="buy-me-a-beer-04">
     <a title="Buy me a Beer!!" href="javascript:document.donate_paypal_b.submit();">
     If this plugin is useful for you, please make a donation.
     The money raised will be used to buy me a beer and maybe a pizza <(^_^)>
     If you help me I\'ll be able to continue doing more cool stuff to Wordpress.</a>
     </div>
     <div id="buy-me-a-beer-05"></div>
     </div>';

     echo '<form method="post" action="'.$_SERVER["REQUEST_URI"].'">
     <table border="0" width="100%" id="table1">
     <tr>
       <td align="right" colspan="2"><p align="left">&nbsp;<b>Setup your Shop</b></td>
     </tr>
      <tr>
       <td align="right" colspan="2"><p align="left">
       To install your Shopping Cart you need create a Page and paste the next code:
       [shopping-cart-chopyshop]<br />Copy the URL of your Shopping Cart and 
       paste in the option "<b>Shopping Cart Page</b>" below.<br />
       You also need create two Pages more for the costumer, One for a successful payment 
       and other for <br />an incorrect payment.<br />
       If you want change the strings or translate the Shopping Cart, you can change<br />
       the text from the  "<b>Shopping Cart Translate</b>" option.
       </td>
     </tr>
     <tr>
       <td colspan="2">&nbsp; <b>Payment Settings</b></td>
     </tr>
     <tr>
       <td align="right" width="220">Paypal Email</td>
     <td><input type="text" name="paypal_email" size="25" value="'.$CONFIG_G['paypal_email'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Currency Symbol</td>
       <td><input type="text" name="simbolo_compra" size="5" value="'.$CONFIG_G['simbolo_compra'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Currency Code</td>
       <td><input type="text" name="divisa" size="5" value="'.$CONFIG_G['divisa'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Language</td>
       <td><input type="text" name="lenguaje" size="5" value="'.$CONFIG_G['lenguaje'].'"></td>
     </tr>
     <tr>
       <td align="right" colspan="2"><p align="left">&nbsp;<b> Paypal / Shopping Cart Settings</b></td>
     </tr>

     <tr>
       <td align="right" width="220">Return page successful payment</td>
       <td><input type="text" name="url_ok" size="40" value="'.$CONFIG_G['url_ok'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Return page incorrect payment</td>
       <td><input type="text" name="url_error" size="40" value="'.$CONFIG_G['url_error'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Shopping Cart Page</td>
       <td><input type="text" name="cc_url" size="40" value="'.$CONFIG_G['cc_url'].'"></td>
     </tr>
     <tr>
       <td align="right" colspan="2"><p align="left">&nbsp;<b>Shopping Cart Translate</b></td>
     </tr>
     <tr>
       <td align="right" width="220">Shopping Cart empty text</td>
       <td><input type="text" name="cc_vacio" size="25" value="'.$CONFIG_G['cc_vacio'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Buy button text</td>
       <td><input type="text" name="bc_titulo" size="25" value="'.$CONFIG_G['bc_titulo'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Continue shopping button text</td>
       <td><input type="text" name="bc_titulo_cc" size="25" value="'.$CONFIG_G['bc_titulo_cc'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Update Cart button text</td>
       <td><input type="text" name="bc_actualizar" size="25" value="'.$CONFIG_G['bc_actualizar'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Checkout button text</td>
       <td><input type="text" name="bc_pedido" size="25" value="'.$CONFIG_G['bc_pedido'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Cart Item text</td>
       <td><input type="text" name="cc_producto_text" size="25" value="'.$CONFIG_G['cc_producto_text'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Cart quantity item text</td>
       <td><input type="text" name="cc_cantidad_text" size="25" value="'.$CONFIG_G['cc_cantidad_text'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Cart amount text</td>
       <td><input type="text" name="cc_precio_text" size="25" value="'.$CONFIG_G['cc_precio_text'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220">Cart total text</td>
       <td><input type="text" name="cc_total_text" size="25" value="'.$CONFIG_G['cc_total_text'].'"></td>
     </tr>
     <tr>
       <td align="right" width="220"></td>
       <td><br /><br /></td>
     </tr>
     <tr>
       <td align="right" width="220"></td>
       <td><input type="submit" value="Save Changes" name="guardar_cambios"><br /><br /></td>
     </tr>
     </table></form>';
     echo '</div></div>';
     echo '</div>';
   }
   
   function configuracion_plugin(){
      add_options_page('Chopy Shop Settings', 'Chopy Shop', 'manage_options', __FILE__, 'opciones_chopyshop');
   }

/* Funciones del Plugin en la entrada */
   function agregar_modulo(){
      global $post;
      $precio_guardado = get_post_meta($post->ID,'cost_cs', true);
      echo 'Cost of product: '
      .'<input type="text" name="cost_cs" '
      .'size="10" value="'.@htmlspecialchars($precio_guardado,ENT_QUOTES).'">';
   }
   
   function agregar_opciones_admin() {
      add_meta_box( 'agregar_modulo', 'Chopy Shop Product Settings', 'agregar_modulo', 'post', 'normal', 'high' );
   }
   
   function guardar_datos( $post_id ){
      global $post;
      $precio = $_POST['cost_cs'];
      if( !empty( $precio ) && is_numeric( $precio ) ){
        if( get_post_meta($post_id, 'cost_cs') == "" ){
            add_post_meta($post_id, 'cost_cs', $precio, true);
        }
        elseif( $precio != get_post_meta($post_id, 'cost_cs', true) ){
          update_post_meta($post_id, 'cost_cs', $precio);
        }
      }
   }
   
/* Carrito de compra */
   function listado_items( $array ){
      if( !empty( $array ) ){
        foreach( $array as $id => $cantidad ){
          $productos_ids .= $id.'-'.$cantidad.',';
        }
        $productos_ids = substr( $productos_ids , 0, - 1 );
        return $productos_ids;
      }
      return false;
   }
   
   function boton_compra_checkout( $total,$items ){
      if( $total ){
         $email_paypal = @htmlspecialchars(get_option('paypal_email'),ENT_QUOTES);
         $divisa = @htmlspecialchars(get_option('divisa'),ENT_QUOTES);
         $lenguage = @htmlspecialchars(get_option('lenguaje'),ENT_QUOTES);
         $pago_ok = @htmlspecialchars(get_option('url_ok'),ENT_QUOTES);
         $pago_error = @htmlspecialchars(get_option('url_error'),ENT_QUOTES);
        
         $boton = '<form action="https://www.paypal.com/cgi-bin/webscr" method="POST">'
                 .'<input type="submit" value="'
                 . @htmlspecialchars(get_option('bc_pedido'),ENT_QUOTES).'" name="submit" />'
                 .'<input type="hidden" name="cmd" value="_xclick" />'
                 .'<input type="hidden" name="business" value="'.$email_paypal.'" />'
                 .'<input type="hidden" name="currency_code" value="'.$divisa.'" />'
                 .'<input type="hidden" name="lc" value="'.$lenguage.'" />'
                 .'<input type="hidden" name="notify_url" value="'.get_option('siteurl').'" />'
                 .'<input type="hidden" name="return" value="'.$pago_ok.'" />'
                 .'<input type="hidden" name="quantity" value="1" />'
                 .'<input type="hidden" name="item_name" value="'
                 .@htmlspecialchars(get_option('cc_producto_text'),ENT_QUOTES)
                 .': '.listado_items($items).'" />'
                 .'<input type="hidden" name="amount" value="'.$total.'" />'
                 .'<input type="hidden" name="custom" value="'.listado_items($items).'," />';
         if( !empty( $pago_error ) ){
            $boton .='<input type="hidden" name="cancel_return" value="'.$pago_error.'" />';
         }
         $boton .='</form>';
      }
      return $boton;
   }
   
  $session_nombre = "chopyshopcart";

  function carrito_de_compra( $contenido ){
     global $post, $session_nombre;
     
     if( isset( $_POST['modificar_carro'] ) ){
        $items_edit = $_POST['cantidad'];
        if( !empty( $items_edit ) ){
           $productos = unserialize( $_SESSION[$session_nombre] );
           foreach( $items_edit as $key => $valor ){
             if( empty( $valor ) ){
                unset( $productos[ $key ] );
             }else{
                $productos[ $key ]['cantidad'] = $valor;
                $productos[ $key ]['precio'] = $valor * get_post_meta($key,'cost_cs', true);
             }
           }
           $_SESSION[$session_nombre] = serialize($productos);
        }
     }
     
     $accion = get_permalink($post->ID);
     $productos = unserialize( $_SESSION[$session_nombre] );
     $simbolo = @htmlspecialchars(get_option('simbolo_compra'),ENT_QUOTES);
     if( !empty( $productos ) ){
        $carrito = '<form method="POST" action="'.$accion.'">
                    <table border="0" width="100%">
                    <tr>
                      <th align="center">'
                      .@htmlspecialchars(get_option('cc_producto_text'),ENT_QUOTES).'</th>
                      <th align="center">'
                      .@htmlspecialchars(get_option('cc_cantidad_text'),ENT_QUOTES).'</th>
                      <th align="center">'
                      .@htmlspecialchars(get_option('cc_precio_text'),ENT_QUOTES).'</th>
                      <th align="center">'
                      .@htmlspecialchars(get_option('cc_total_text'),ENT_QUOTES).'</th>
                    </tr>';
        $total = 0;
        foreach( $productos as $key => $valor ){
           $carrito .='<tr>'
                    . '<td align="center"><a href="'.get_permalink($key).'">'
                    .get_the_title($key).'</a></td>'
                    . '<td align="center">'
                    . '<input type="text" name="cantidad['.$key.']" size="5" value="'.$valor['cantidad'].'"></td>'
                    . '<td align="center">'.$simbolo.$valor['precio'].'</td>'
                    . '<td align="center">'.$simbolo.$valor['precio'].'</td>'
                    .'</tr>';
           $total = $total + $valor['precio'];
           $ids[$key] = $valor['cantidad'];
        }
        $carrito .='<tr>'
                 . '<td align="center"></td>'
                 . '<td align="center"></td>'
                 . '<td align="center"></td>'
                 . '<td align="center"><b><font color="#FF0000">'
                 . $simbolo.$total.'</font></b></td>'
                 . '</tr>';
        $carrito .= "</table><br />";
        $carrito .= '<table border="0" width="100%">
                     <tr>
                       <td><input type="button" value="'
                       .@htmlspecialchars(get_option('bc_titulo_cc'),ENT_QUOTES).'" '
                       .'name="continuar_comprando" '
                       .'onclick="window.location.href=\''
                       .@htmlspecialchars(get_option('siteurl'),ENT_QUOTES).'\'"/></td>
                       <td><input type="submit" value="'
                       .@htmlspecialchars(get_option('bc_actualizar'),ENT_QUOTES).'" name="modificar_carro" /></form></td>
                       <td>'.boton_compra_checkout($total,$ids).'</td>
                     </tr>
                     </table>';
        
     }else{
       $carrito = @htmlspecialchars(get_option('cc_vacio'),ENT_QUOTES);
     }
     $contenido = str_replace("[shopping-cart-chopyshop]", $carrito, $contenido);
     return $contenido;
  }
  
  function paypal_IPN(){
     if ( !function_exists ( 'curl_init' ) ){ return false; }
     $url_paypal = 'cmd=_notify-validate';
     $simbolo = @htmlspecialchars(get_option('simbolo_compra'),ENT_QUOTES);
     $divisa = @htmlspecialchars(get_option('divisa'),ENT_QUOTES);
     foreach ($_POST as $key => $valor) {
        $valor = urlencode( stripslashes($valor) );
        $url_paypal .= "&".$key."=".$valor;
     }
     $ch = curl_init ( );
      curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ( $ch, CURLOPT_URL, 'https://www.paypal.com/cgi-bin/webscr' );
      curl_setopt ( $ch, CURLOPT_POST, 1); 
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $url_paypal);
      curl_setopt ( $ch, CURLOPT_TIMEOUT, 90);
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1);
      $buffer = curl_exec ( $ch );
      $SALIDA['respuesta'] = $buffer;
      if (strcmp ($buffer, "INVALID") == 0) {
         return false;
      }
      if (strcmp ($buffer, "VERIFIED") == 0) {
         $items_list = explode(',',$_POST[ 'custom' ]);
         if( !empty( $items_list ) ){
            foreach( $items_list as $item ){
               $item_sep = explode('-',$item);
               $item_nombre = get_the_title($item_sep[0]);
               $item_link   = get_permalink($item_sep[0]);
               $item_costo  = get_post_meta($item_sep[0],'cost_cs', true);
               $item_cantidad = $item_sep[1];
               $item_total = $item_costo * $item_cantidad;
               $productos .= '<hr noshade size="1">'
                            .'Item: <a href="'.$item_link.'">'.$item_nombre.'</a><br />'
                            .'Quantity : '.$item_cantidad .'<br />'
                            .'Individual amount: '.$simbolo.$item_costo.' '.$divisa.'<br />'
                            .'Total: <b>'.$simbolo.$item_total .' '.$divisa.'</b><br /><br />';
               if( !$total_pedido ){
                  $total_pedido = $item_total;
               }else{
                 $total_pedido = $total_pedido+$item_total;
               }
            }
            
            $mensaje = '<h3>Order details</h3>'
               .'<b>Customer Name:</b> '.$_POST[ 'first_name' ].' '.$_POST[ 'last_name' ].'<br />'
               .'<b>E-mail:</b> '.$_POST[ 'payer_email' ].'<br />'
               .'<b>Phone:</b> '.$_POST[ 'contact_phone' ].'<br />'
               .'<b>Country:</b> '.$_POST[ 'address_country' ].'<br />'
               .'<b>City:</b> '.$_POST[ 'address_city' ].'<br />'
               .'<b>Address:</b> '.$_POST[ 'address_street' ].'<br />'
               .'<b>Address name:</b> '.$_POST[ 'address_name' ].'<br />'
               .'<b>Address state:</b> '.$_POST[ 'address_state' ].'<br />'
               .'<b>Address status:</b> '.$_POST[ 'address_status' ].'<br />'
               .'<b>Zip code:</b> '.$_POST[ 'address_zip'].'<br />'
               .'<b>Total Amount:</b> <b><font color="#FF0000" >'
               .$simbolo.$_POST[ 'mc_gross' ].' '.$divisa.'</font></b><br />'
               .'<b>ID Transaction:</b> '.$_POST[ 'txn_id' ].'<br />'
               .'<b>Date:</b> '.date('d-m-Y H:i',time()).'<br />'
               .'<br /><br /><b>Products:</b> <br />'.$productos.'<br />';
            
            $mensaje .='<b>Total Amount:</b> <b><font color="#FF0000" >'
            .$simbolo.$_POST[ 'mc_gross' ].' '.$divisa.'</font></b><br /><br />';
            
            if( $_POST[ 'mc_gross' ] < $total_pedido || $_POST[ 'mc_gross' ] > $total_pedido){
               $mensaje .= '<b><font color="#FF0000" size="5">'
                          .'ALERT: TOTAL AMOUNT DID NOT MATCH!!!</font></b><br /><br />';
            }
            
            $headers  = "From: Chopy Shop<chopyshop@oders.com>\r\n";
            $headers .= "Content-type: text/html\r\n";
            
            @mail( get_option('admin_email'),'New Order From: '.get_option('blogname'),$mensaje,$headers);
            return true;
         }
      }
      return false;
  }
  
  function atrapar_paypal_IPN( $contenido ){
    if( isset( $_POST['txn_id'] )){
       paypal_IPN();
    }
    return $contenido;
  }
/* Boton de compra */
   function agregar_pedido(){
      global $post, $session_nombre;
      if( isset($_POST['agregar_producto']) ){
         $productos = $_SESSION[$session_nombre];
         if( !empty($productos) ){
            $productos = unserialize( $productos );
         }else{
            $productos = array();
         }
         $cantidad = $productos[ $_POST['item_id'] ]['cantidad'];
         if( $cantidad < 1 ){
           $cantidad = 1;
         }else{
           $cantidad++;
         }
         $productos[ $_POST['item_id'] ]['cantidad'] = $cantidad;
         $productos[ $_POST['item_id'] ]['precio'] = $_POST['item_precio'] * $cantidad;
         
         $_SESSION[$session_nombre] = serialize( $productos );
      }

   }
   
   function boton_compra( $contenido ){
      global $post;
      
      $accion = get_permalink($post->ID);
      if( get_option('cc_url') != "" ){
         $accion = get_option('cc_url');
      }
      
      agregar_pedido();
      
      $precio = get_post_meta($post->ID,'cost_cs', true);
      if( $precio ){
         $boton = '<form  method="post" action="'.$accion.'" id="frm_ep" onsubmit="boton_compra(this)">
         <input type="submit" name="agregar_producto" value=" - '
         .@htmlspecialchars(get_option('simbolo_compra'),ENT_QUOTES).$precio.' - '
         .@htmlspecialchars(get_option('bc_titulo'),ENT_QUOTES).'">';
         $salida = '<p align="center">'.$boton.'</p>'
         .'<input type="hidden" name="item_id" value="'.$post->ID.'" />'
         .'<input type="hidden" name="item_precio" value="'.$precio.'" />'
         .'</form><br /><br />';
      }
   
      return $contenido.$salida;
   }
   
   /*Al activar el plugin*/
   global $chopy_shop_config;
   $chopy_shop_config = config_general();
   register_activation_hook( __FILE__, 'instalar_datos_default' );
   
   /*Boton de compra en el post*/
   add_filter('the_content','boton_compra');
   
   /*Javascript*/
  // add_action('wp_head', 'scripts_chopy_shop');
   
   /*Carro de compras*/
   add_filter('the_content','carrito_de_compra');
   add_action('the_content','atrapar_paypal_IPN');
  
   /*Input en edicion del post*/
   add_action('admin_menu', 'agregar_opciones_admin');
   
   /* Al guardar Datos... */
   add_action('save_post', 'guardar_datos');
   
   add_action('admin_menu','configuracion_plugin');



?>