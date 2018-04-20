<?php
declare(strict_types = 1);

namespace joker2620\Source\API;

use joker2620\Source\Engine\BotFunction;
use joker2620\Source\Exception\BotError;
use joker2620\Source\Setting\Config;
use VK\Client\VKApiClient;
use VK\TransportClient\Curl\CurlHttpClient;


/**
 * Class VKAPI
 *
 * @property CurlHttpClient http_client
 * @package joker2620\Source\API
 */
class VKAPI extends VKApiClient
{
    private $accessToken, $botFucntion, $httpClient;

    /**
     * VKAPI constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->httpClient  = new CurlHttpClient(10);
        $this->accessToken = Config::getConfig()['ACCESS_TOKEN'];
        $this->botFucntion = new BotFunction();
    }

    /**
     * curl()
     *
     * @param string $url
     *
     * @param bool   $noJsonDecode
     *
     * @return CurlHttpClient
     * @throws BotError
     */
    public function curlGet(string $url, $noJsonDecode = false)
    {
        $curl_init_ = curl_init($url);

        curl_setopt_array(
            $curl_init_, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false
            ]
        );

        $response        = curl_exec($curl_init_);
        $curl_error_code = curl_errno($curl_init_);
        $curl_error      = curl_error($curl_init_);

        curl_close($curl_init_);

        if ($curl_error || $curl_error_code) {
            $error_msg = "Failed curl request. Curl error {$curl_error_code}";
            if ($curl_error) {
                $error_msg .= ": {$curl_error}";
            }

            $error_msg .= '.';

            throw new BotError($error_msg);
        }
        return $noJsonDecode ? $response : json_decode($response, true);
    }

    /**
     * uploadVoice()
     *
     * @param int    $user_id
     * @param string $file_name
     *
     * @return mixed
     */
    public function uploadVoice(int $user_id, string $file_name)
    {
        $server_response = $this->docsGUServer($user_id, 'audio_message');
        $upload_response = $this->upload($server_response['upload_url'], $file_name, 'file');
        $files           = $upload_response['file'];
        $save_response   = $this->docsSave($files, 'Voice message');
        $doccx           = max($save_response);
        return $doccx;
    }


    /**
     * docsGUServer()
     *
     * @param int    $peer_id
     * @param string $type
     *
     * @return mixed
     */
    public function docsGUServer(int $peer_id, string $type)
    {
        return $this->docs()->getMessagesUploadServer(
            $this->accessToken,
            [
                'peer_id' => $peer_id,
                'type' => $type,
            ]
        );
    }


    /**
     * upload()
     *
     * @param string $url
     * @param        $file_name
     * @param string $type
     *
     * @return mixed
     */
    public function upload(string $url, $file_name, string $type = 'photo')
    {
        return $this->getRequest()->upload($url, $type, $file_name);
    }


    /**
     * docsSave()
     *
     * @param string $file
     * @param string $title
     *
     * @return mixed
     */
    public function docsSave(string $file, string $title)
    {
        return $this->docs()->save(
            $this->accessToken, [
                'file' => $file,
                'title' => $title,
            ]
        );
    }


    /**
     * methodAPI()
     *
     * @param string $method
     * @param array  $params
     *
     * @return mixed
     */
    public function methodAPI(string $method, array $params = [])
    {
        $access_token = $this->getToken($params);
        return $this->getRequest()->post($method, $access_token, $params);
    }


    /**
     * getToken()
     *
     * @param array $parameters
     *
     * @return mixed
     */
    private function getToken(array $parameters)
    {
        $token = $this->accessToken;
        if (is_array($parameters)) {
            if (isset($parameters['access_token'])
                && is_string($parameters['access_token']) && '' != $parameters['access_token']
            ) {
                $token = $parameters['access_token'];
            }
        }
        return $token;
    }


    /**
     * uploadPhoto()
     *
     * @param int $peer_id
     * @param     $file_name
     *
     * @return mixed
     */
    public function uploadPhoto(int $peer_id, $file_name)
    {
        $server_response = $this->photosGUServer($peer_id);
        $upload_response = $this->upload($server_response['upload_url'], $file_name);
        $photo           = $upload_response['photo'];
        $server          = $upload_response['server'];
        $hashd           = $upload_response['hash'];
        $save_response   = $this->photoSave($photo, $server, $hashd);
        $photo           = max($save_response);
        return $photo;
    }


    /**
     * photosGUServer()
     *
     * @param int $peer_id
     *
     * @return mixed
     */
    public function photosGUServer(int $peer_id)
    {
        return $this->photos()->getMessagesUploadServer(
            $this->accessToken,
            [
                'peer_id' => $peer_id,
            ]
        );
    }


    /**
     * photoSave()
     *
     * @param string $photo
     * @param int    $server
     * @param string $hash
     *
     * @return mixed
     */
    public function photoSave(string $photo, int $server, string $hash)
    {
        return $this->photos()->saveMessagesPhoto(
            $this->accessToken,
            [
                'photo' => $photo,
                'server' => $server,
                'hash' => $hash,
            ]
        );
    }


    /**
     * messagesSend()
     *
     * @param int    $peer_id
     * @param string $message
     * @param array  $attachment
     *
     * @return mixed
     */
    public function messagesSend(
        int $peer_id, string $message = '', $attachment = []
    ) {
        return $this->messages()->send(
            $this->accessToken,
            [
                'peer_id' => $peer_id,
                'message' => $message ?
                    $this->botFucntion->ucFirst($message) :
                    Config::getConfig()['MESSAGE']['noAnswer'],
                'attachment' => $attachment ?
                    implode(',', $attachment) : false,
            ]
        );
    }


    /**
     * usersGet()
     *
     * @param int        $peer_id
     * @param array|null $param
     *
     * @return mixed
     */
    public function usersGet(
        int $peer_id,
        ?array $param
        = [
            'first_name_abl', 'first_name_ins', 'first_name_acc',
            'first_name_dat', 'first_name_gen', 'last_name_abl',
            'last_name_ins', 'last_name_acc', 'last_name_dat',
            'last_name_gen'
        ]
    ) {
        if (empty($param)) {
            $param = ['timezone', 'sex', 'photo_50', 'city'];
        } else {
            $param = array_merge($param, ['timezone', 'sex', 'photo_50', 'city']);
        }
        return $this->users()->get(
            $this->accessToken, [
                'user_ids' => $peer_id,
                'fields' => $param,
            ]
        );
    }
}
