<?php
namespace Discord;

require 'config.php';

class Webhook
{
    private string $_url;
    private array $_options;
    private array $_body;
    private mixed $_geo;

    public function __construct(mixed $geo)
    {

        global $config;

        $this->_geo = $geo;
        $this->_url = $config['URL'];

        if (!$this->_url) {
            echo "URL do Webhook não foi setada";
        }

        $this->_body = [
            "username" => "Aurora",
            "avatar_url" => $config['AVATAR'],
            "content" => $this->response(),
        ];

        $this->_options = [
            CURLOPT_URL => $this->_url,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => json_encode($this->_body),
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
        ];

        $this->send();
    }

    private function response(): string
    {
        if (!$this->_geo) {
            return "Ocorreu um erro.";
        }

        $data = $this->_geo['data'];
        $asn = $data["asn"];
        $company = $data["company"];
        $privacy = $data["privacy"];
        $abuse = $data["abuse"];

        return sprintf(
            "# Informações do IP \n\nIP: %s \nHostname: %s \n\n# Informações da Cidade \nPais: %s \nEstado: %s \nCidade: %s \nLocalização: %s \nCódigo Postal: %s \nTimezone: %s \n\n# Informações da ASN \nASN: %s \nORG: %s \nNome: %s \nDomínio: %s \nRota: %s \nTipo: %s \n\n# Informações da Companhia \nNome: %s \nDomínio: %s \nTipo: %s \n\n# Informações de Privacidade \nVPN: %s \nProxy: %s \nTor: %s \nRelay: %s \nHosting: %s \nServiço: %s \n\n# Informações de Abuso \nEndereço: %s \nPaís: %s \nEmail: %s \nNome: %s \nRede: %s \nTelefone: %s",
            $data["ip"],
            $data["hostname"],
            $data["country"],
            $data["region"],
            $data["city"],
            $data["loc"],
            $data["postal"],
            $data["timezone"],
            $asn["asn"],
            $data["org"],
            $asn["name"],
            $asn["domain"],
            $asn["route"],
            $asn["type"],
            $company["name"],
            $company["domain"],
            $company["type"],
            $privacy["vpn"] ? 'Sim' : 'Não',
            $privacy["proxy"] ? 'Sim' : 'Não',
            $privacy["tor"] ? 'Sim' : 'Não',
            $privacy["relay"] ? 'Sim' : 'Não',
            $privacy["hosting"] ? 'Sim' : 'Não',
            $privacy["service"],
            $abuse["address"],
            $abuse["country"],
            $abuse["email"],
            $abuse["name"],
            $abuse["network"],
            $abuse["phone"]
        );
    }

    private function send(): void
    {
        $instance = curl_init();

        curl_setopt_array($instance, $this->_options);
        curl_exec($instance);
        curl_close($instance);
    }

}
