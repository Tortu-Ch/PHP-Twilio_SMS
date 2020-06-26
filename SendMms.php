<?php
/**
 * Created by PhpStorm.
 * User: DRAGON
 * Date: 5/23/2019
 * Time: 3:26 AM
 */
require __DIR__ . '/twilio-php-master/Twilio/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
class SendMms
{
    const sid = 'AC1d9a85ec880e91f93818160bab628a58';
    const token = '0a40e4e00137dcaa53f3beb0bd879b7f';
    const fromNum = '+13124294996';
//    const fromNum = '+18474293544';
    private $client = null;

    function __construct()
    {
        $this->client = new Client(self::sid, self::token);
    }

    public function MessageCreat($toNum, $body, $mediaUrl)
    {
        if($mediaUrl)
        {
            $message=$this->client->messages->create(
                $toNum,
                array(
                    'from'=>self::fromNum,
                    'body'=>$body,
                    'mediaUrl'=>$mediaUrl));
        }
        else{
            $message=$this->client->messages->create(
                $toNum,
                array(
                    'from'=>self::fromNum,
                    'body'=>$body));
        }
        return $message->sid;
    }

    public  function MessageRead($to=self::fromNum,$limit=50)
    {
        $messages = $this->client->messages->read(array('to'=>$to,'status'=>'received'), $limit);
        return $messages;
    }

    public function MessageDelte($sid)
    {
        $this->client->messages($sid)->delete();
    }

    public function MediaIdRead($sid)
    {
        $media = $this->client->messages($sid)->media->read(array(), 1);
        if($media) {
            foreach ($media as $record) {
                return $record->sid;
            }
        }
        return false;
    }

    public function MediaRead($sid)
    {
        $mediaId = $this->MediaIdRead($sid);
        if($mediaId) {
            $media = $this->client->messages($sid)->media($mediaId)->fetch();
            return $media;
        }
        return null;
    }

    function makeRequest($url, $callDetails = false)
    {
        // Set handle
        $ch = curl_init($url);

        // Set options
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute curl handle add results to data return array.
        $result = curl_exec($ch);
        $returnGroup = ['curlResult' => $result,];

        // If details of curl execution are asked for add them to return group.
        if ($callDetails) {
            $returnGroup['info'] = curl_getinfo($ch);
            $returnGroup['errno'] = curl_errno($ch);
            $returnGroup['error'] = curl_error($ch);
        }

        // Close cURL and return response.
        curl_close($ch);
        return $returnGroup;
    }

}