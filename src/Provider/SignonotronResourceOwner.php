<?php namespace Learningpool\OAuth2\Client\Provider;
class SignonotronResourceOwner implements ResourceOwnerInterface
{
    /**
     * Domain
     *
     * @var string
     */
    protected $domain;
    /**
     * Raw response
     *
     * @var array
     */
    protected $response;
    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response['user'];
    }
    /**
     * Get resource owner id
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->response['uid'] ?: null;
    }
    /**
     * Get resource owner email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->response['email'] ?: null;
    }
    /**
     * Get resource owner name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->response['name'] ?: null;
    }
    /**
     * Get resource owner permissions
     *
     * @return string|null
     */
    public function getPermissions()
    {
        return implode(",", $this->response['permissions']) ?: null;
    }
    /**
     * Get resource owner name
     *
     * @return string|null
     */
    public function getOrganisation()
    {
        return $this->response['organisation_slug'] ?: null;
    }
    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}