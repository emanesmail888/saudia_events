<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class sendWhatsapMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:WhatsappMessageCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $phone = '+201003452188';
        $access_token = 'EAB5pyZAnHWMcBO4AZAJYtqlPTkwQHLZCn5X06WIK8XC5hc44TMwr6vMOzCmf63I3UWzorIzx2uytazreE0MH3gOtXFmF2iND6tSuNP1v3X5YZCn8CgupO3vmIoWhEgSprmesC5OSrZC43aWmYzljHOek38QUVZAZB6nppyFDau2v4S9HrDzBOQUaZCZC6aowiIrGaRF2uTfUpWWCZBRU4wSFIZD';
        $template_name = 'whats_messages';


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v15.0/396941606836645/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false),
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(array(
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'template',
                'template' => array(
                    'name' => $template_name,
                    'language' => array(
                        'code' => 'en_US'
                    ),
                    'components' => array(
                        array(
                            'type' => 'header',
                            'parameters' => array(
                                array(
                                    'type' => 'image',
                                    'image' => array(
                                        'link' => 'https://example.com/image.jpg'
                                    )
                                )
                            )
                        ),
                        array(
                            'type' => 'body',
                            'parameters' => array(
                               
                            )
                        ),
                        array(
                            'type' => 'button',
                            'sub_type' => 'quick_reply',
                            'index' => '0',
                            'parameters' => array(
                                array(
                                    'type' => 'text',
                                    'text' => 'Click me'
                                )
                            )
                        )
                    )
                )
            )),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ),
        ));
    
        $response = curl_exec($curl);
    
        if ($response === false) {
            echo 'Error: ' . curl_error($curl);
        } else {
            echo $response;
        }
    
        curl_close($curl);
        return 0;
    }

   

}
