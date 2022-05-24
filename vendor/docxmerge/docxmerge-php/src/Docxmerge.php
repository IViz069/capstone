<?php

namespace Docxmerge;


class Docxmerge
{
    private $apiKey;
    private $baseUrl;
    private $tenant;

    public function __construct($apiKey, $tenant = "default", $baseUrl = "https://api.docxmerge.com")
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
        $this->tenant = $tenant;
    }

    public function renderTemplate($fp, $templateName, $data, $conversionType, $version = "")
    {
        $baseUrl = $this->baseUrl;
        $apiKey = $this->apiKey;
        $tenant = $this->tenant;

        $ch = curl_init("$baseUrl/api/v1/Admin/RenderTemplate");

        $payload = json_encode(array(
            "data" => $data,
            "template" => $templateName,
            "conversionType" => $conversionType,
            "version" => $version,
        ));

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_POST, 1);
        $body_len = strlen($payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                "Content-Length:$body_len",
                "api-key: $apiKey",
                "x-tenant: $tenant",
            )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code != "200") throw new \Exception("Unexpected status code $http_code");
    }

    public function renderUrl($fp, $url, $data, $conversionType)
    {
        $baseUrl = $this->baseUrl;
        $apiKey = $this->apiKey;
        $tenant = $this->tenant;

        $ch = curl_init("$baseUrl/api/v1/Admin/RenderUrl");

        $payload = json_encode(array(
            "data" => $data,
            "url" => $url,
            "conversionType" => $conversionType,
        ));

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_POST, 1);
        $body_len = strlen($payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                "Content-Length:$body_len",
                "api-key: $apiKey",
                "x-tenant: $tenant",
            )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code != "200") throw new \Exception("Unexpected status code $http_code");
    }

    public function renderFile($fp, $docxPath, $data, $conversionType)
    {
        $baseUrl = $this->baseUrl;
        $apiKey = $this->apiKey;
        $tenant = $this->tenant;

        $ch = curl_init("$baseUrl/api/v1/Admin/RenderFile");

        $payload = json_encode($data);

        $options = array(
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(
                "api-key: $apiKey",
                "x-tenant: $tenant",
            ),
            CURLOPT_POSTFIELDS => array(
                'file' => new \CurlFile("$docxPath", '', 'file'),
                'data' => $payload,
                'conversionType' => $conversionType
            ),
            CURLOPT_FILE => $fp,
        );
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code != "200") throw new \Exception("Unexpected status code $http_code");
    }
}