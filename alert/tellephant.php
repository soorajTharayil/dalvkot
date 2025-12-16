<?php
class Tellephant {

    private $apiUrl = "https://api.tellephant.com/v1/send-message";
    private $apiKey = "6hASavMbFsYyz112baQsQB5s7oAV82tFMV6lWSQhEWA43Ain1P4TteszKTUJ"; // put your API key here

    /**
     * Send WhatsApp template message
     *
     * @param string $to         Receiver number (with country code)
     * @param string $templateId Template name/id from Tellephant
     * @param array  $params     Array of template parameter values
     * @param string $language   Language code (default: 'en')
     * @return array|string
     */
    public function sendTemplateMessage($to, $templateId, $params = [], $language = "en") {
        // Prepare payload
        $payload = [
            "apikey"   => $this->apiKey,
            "to"       => $to,
            "channels" => ["whatsapp"],
            "whatsapp" => [
                "contentType" => "template",
                "template"    => [
                    "templateId" => $templateId,
                    "language"   => $language,
                    "components" => [
                        [
                            "type"       => "body",
                            "parameters" => array_map(function($text) {
                                return ["type" => "text", "text" => $text];
                            }, $params)
                        ]
                    ]
                ]
            ]
        ];

        return $this->sendRequest($payload);
    }

    private function sendRequest($payload) {
        $ch = curl_init($this->apiUrl);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return ["error" => curl_error($ch)];
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}

