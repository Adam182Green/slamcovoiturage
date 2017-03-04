<?php

namespace GSB\CovoitBundle\Entity;

class Login
{
    private $email;
    private $motDePasse;

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

}
