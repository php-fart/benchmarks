<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: user.proto

namespace App\User\DTO;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\RepeatedField;

/**
 * Generated from protobuf message <code>app.Address</code>
 */
class Address extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string street = 1;</code>
     */
    protected $street = '';
    /**
     * Generated from protobuf field <code>string city = 2;</code>
     */
    protected $city = '';
    /**
     * Generated from protobuf field <code>string state = 3;</code>
     */
    protected $state = '';
    /**
     * Generated from protobuf field <code>string zip = 4;</code>
     */
    protected $zip = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $street
     *     @type string $city
     *     @type string $state
     *     @type string $zip
     * }
     */
    public function __construct($data = NULL) {
        \App\User\GPBMetadata\User::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string street = 1;</code>
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Generated from protobuf field <code>string street = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setStreet($var)
    {
        GPBUtil::checkString($var, True);
        $this->street = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string city = 2;</code>
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Generated from protobuf field <code>string city = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setCity($var)
    {
        GPBUtil::checkString($var, True);
        $this->city = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string state = 3;</code>
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Generated from protobuf field <code>string state = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkString($var, True);
        $this->state = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string zip = 4;</code>
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Generated from protobuf field <code>string zip = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setZip($var)
    {
        GPBUtil::checkString($var, True);
        $this->zip = $var;

        return $this;
    }

}

