<?php

namespace Elijahcruz\Avatar;

use Elijahcruz\Avatar\Exception\GeneratorTypeNotFound;
use Elijahcruz\Avatar\Exception\IdentifierTypeNotSupportedException;

class Avatar
{
    public mixed $identifier;

    public string $generator;

    public array $options;

    /**
     * Generates a url for your avatar
     */
    public function __construct(mixed $identifier, string $generator = 'gravatar', array $options = [])
    {
        if( is_string( $identifier ) )
        {
            $this->identifier = strtolower(trim($identifier));
        }
        elseif( is_integer( $identifier ) )
        {
            $this->identifier = $identifier;
        }
        else{
            throw new IdentifierTypeNotSupportedException('The first parameter in Elijahcruz\\Avatar\\Avatar only accepts the types string and int, ' . gettype($identifier) . ' was given');
        }

        $this->generator = $generator;

        $this->options = $options;
    }

    public function getUrl() : string
    {
        switch ($this->generator)
        {
            case "gravatar":
                $url = $this->usegravatar();
                break;
            default:
                throw new GeneratorTypeNotFound('Generator: ' . $this->generator . ' is not a valid option.');
                break;
        }

        return $url;
    }

    public function gravatar() : self
    {
        $this->generator = 'gravatar';

        return $this;
    }

    public function uiavatars() : self
    {
        $this->generator = 'uiavatars';
        
        return $this;
    }

    public function option(string $key, string $value) : self
    {
        array_push($this->options, [ $key => $value ] );

        return $this;
    }

    public function options(string $options) : self
    {
        foreach ( $options as $key => $value )
        {
            array_push($this->options, [ $key => $value ] );
        }

        return $this;
    }

    private function usegravatar() : string
    {
        $url = "https://www.gravatar.com/avatar/" . md5($this->identifier);

        $firstOption = true;

        if( array_key_exists( 'default', $this->options ) )
        {
            $url = $url . '?d=' . urlencode($this->options['default']);
            
            $firstOption = false;

        }

        if( array_key_exists( 'force_default', $this->options ) )
        {

            if( $firstOption )
            {
                if( $this->options['force_default'] )
                {
                    $url = $url . '?f=y';
                    $firstOption = false;
                }
                else
                {
                    $url = $url . '?f=n';
                    $firstOption = false;
                }
            }
            else{
                if( $this->options['force_default'] )
                {
                    $url = $url . '&f=y';
                }
                else
                {
                    $url = $url . '&f=n';
                }
            }

        }

        if( array_key_exists( 'rating', $this->options ) )
        {

            if( $firstOption )
            {
                $url = $url . '?r=' . $this->options['rating'];
                $firstOption = false;
            }
            else{
                $url = $url . '&r=' . $this->options['rating'];
            }

        }

        if( array_key_exists( 'size', $this->options ) )
        {

            if( $firstOption )
            {
                $url = $url . '?s=' . $this->options['size'];
                $firstOption = false;
            }
            else{
                $url = $url . '&r=' . $this->options['size'];
            }

        }

        if( array_key_exists( 'extension', $this->options ) )
        {

            $url = $url . $this->options['extension'];

        }

        return $url;
    }

    private function useuiavatars() : string
    {
        $url = 'https://ui-avatars.com/api/?name=' . urlencode($this->identifier);

        return $url
    }
}