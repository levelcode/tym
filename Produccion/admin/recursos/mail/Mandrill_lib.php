<?php

require "Mandrill.php";
class Mandrill_lib {
	
	public function send_remission_email( $account, $template_name_to_send, $timestamp, $attach ){
		
		$list_id = 'e7d9615355';
		$language = 'es_ES';
		
		// $merge_vars = array('FNAME' => $account->first_names,
		// 					'LNAME' => $account->last_names,
		// 					'MC_LANGUAGE' => $language 
		// );

        $campaign_id = "ea588c4f49";

        try {

             $CI = new \Mandrill();

            // $result = $CI->users->ping();

            // die(var_dump($result));

            $template_name = $template_name_to_send;
            $template_content = array(
                array(
                    'name' => 'example name',
                    'content' => 'example content'
                )
            );

            if( !isset($account['data']['customEmail']['email']) ) {
                $account['data']['customEmail']['email'] = $account['data']['clientEmail'];
            }

            $message = array(
                //'html' => '<p>Example HTML content</p>',
                //'text' => 'Example text content',
                'subject' => 'Nueva remision generada el ' . date('Y-m-d H:i:s', $timestamp),
                'from_email' => 'remisiones@cartecrudo.com',
                'from_name' => 'Equipo cartecrudo.com',
                'to' => array(
                    array(
                        'email' => $account['data']['customEmail']['email'],
                        //'name' => $account->first_names,
                        'type' => 'to'
                    )
                ),
                //'headers' => array('Reply-To' => 'registro@virtualfarma.com.co'),
                'important' => false,
                //'track_opens' => null,
               //track_clicks' => null,
                //'auto_text' => null,
                //'auto_html' => null,
                //'inline_css' => null,
                //'url_strip_qs' => null,
                //'preserve_recipients' => null,
                'view_content_link' => null,
                //'bcc_address' => $account['data']['clientEmail'],
                //'tracking_domain' => null,
                //'signing_domain' => null,
               // 'return_path_domain' => null,
                //'merge' => true,
                'merge_language' => 'mailchimp',
                'global_merge_vars' => array(
                    array(
                            'name' => 'COMPANY',
                            'content' => "ORCO"
                        )
                ),
                'merge_vars' => array(
                    array(
                        'rcpt' => $account['data']['customEmail']['email'],
                        'vars' => array(
                            array(
                                'name' => 'NOTES',
                                'content' => $account['data']['customEmail']['notes']
                            )/*,
                            array(
                                'name' => 'COMPANY',
                                'content' => "endometfarma.com"
                            ),
                            array(
                                'name' => 'LNAME',
                                'content' => $account->last_names,
                            ),
                            array(
                                'name' => 'EMAIL',
                                'content' => $account->email,
                            ),
                            array(
                                'name' => 'PASSWORD',
                                'content' => $account->password,
                            ),
                            array(
                                'name' => 'CC',
                                'content' => $account->identification,
                            )*/
                        )
                    )
                ),
                'tags' => array('orco_remission'),
               // 'subaccount' => 'customer-123',
              //  'google_analytics_domains' => array('example.com'),
               // 'google_analytics_campaign' => 'message.from_email@example.com',
                //'metadata' => array('website' => 'www.virtualfarma.com.co'),
                //'recipient_metadata' => array(
                  //  array(
                    //    'rcpt' => $account->email,
                      //  'values' => array('user_id' => 123456)
                    //)
                //),
                'attachments' => array(
                    array(
                        'type' => 'application/pdf',
                        'name' => $attach->name,
                        'content' => $attach->fichero_in_base64
                    )
                )/*,
                'images' => array(
                    array(
                        'type' => 'image/png',
                        'name' => 'IMAGECID',
                        'content' => 'ZXhhbXBsZSBmaWxl'
                    )
                )*/




            );
            $async = false;
            $ip_pool = 'orco_remission';
            //$send_at = 'example send_at';
            $result = $CI->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
            return $result;
            


        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }

		return FALSE;
		
	}

}