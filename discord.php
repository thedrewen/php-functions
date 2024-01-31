<?php

$token_bot = "";
$api_version = 10;
$api_url = "https://discord.com/api/v".$api_version;

function sendDiscordRequest($token, $url)
{
    $headers = array(
        "Authorization: Bot {$token}"
    );

    $options = array(
        'http' => array(
            'header'  => implode("\r\n", $headers),
            'method'  => 'GET',
        )
    );

    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        return false;
    }

    $data = json_decode($response, true);
    return $data;
}



class Guild
{

    public int $id;
    public string $name;
    public string $icon;
    public int $member_count;

    public array $data;

    public function __construct($guild_id)
    {  
        global $token_bot, $api_url;
        $this->id = $guild_id;

        $data = sendDiscordRequest($token_bot, $api_url . "/guilds/".$guild_id."?with_counts=true");
        
        $this->name = $data["name"];
        $this->icon = "https://cdn.discordapp.com/icons/".$guild_id."/".$data["icon"].".webp";
        $this->member_count = $data["approximate_member_count"];

        $this->data = $data;
    }

}
