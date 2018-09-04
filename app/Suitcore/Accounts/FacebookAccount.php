<?php 

namespace Suitcore\Accounts;

class FacebookAccount implements SocialAccountInterface {
    // ATTRIBUTES
    private $id;
    private $data;
    private $token;
    private $randomPassword;

    // METHODS
    public function __construct($id, $data, $token = null)
    {
        $this->id   = $id;
        $this->data = $data;
        $this->token = $token;
    }

    public function getType() {
        return "facebook";
    }

    public function getIdentifierColumn()
    {
        return 'fb_id';
    }

    public function getTokenColumn()
    {
        return 'fb_access_token';
    }

    public function getSecretColumn()
    {
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        if(!isset($this->data['id']))
            return false;

        return $this->data['id'];
    }

    public function getEmail()
    {
        if(!isset($this->data['email']))
            return false;

        return $this->data['email'];
    }

    public function getName()
    {
        if(!isset($this->data['name']))
            return false;

        return $this->data['name'];
    }

    public function getGender()
    {
       if(!isset($this->data['gender']))
            return false;

        return strtoupper($this->data['gender']);
    }

    public function getLocation()
    {
        return false;
    }

    public function getBio()
    {
       if(!isset($this->data['bio']))
            return false;

        return $this->data['bio'];
    }

    public function getPicture()
    {
        if(!isset($this->data['picture']['data']['url']))
            return false;

        return $this->data['picture']['data']['url'];

    }

    public function getAccessToken()
    {
        return $this->token;
    }

    public function getSecret()
    {
        return '';
    }

    public function getRandomPassword()
    {
        if ($this->randomPassword == null || empty(trim($this->randomPassword))) {
            $this->randomPassword = str_random(5);
        }
        return $this->randomPassword;
    }
}
