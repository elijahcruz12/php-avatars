<?php

namespace Elijahcruz\Avatar;

use Elijahcruz\Avatar\Exception\GeneratorTypeNotFound;
use Elijahcruz\Avatar\Exception\IdentifierTypeNotSupportedException;
use Illuminate\Foundation\Auth\User;

class AvatarLaravel
{
    /**
     * This is the identifier. It is mixed incase we end up adding a generator that uses integers
     * @var mixed
     */
    private mixed $identifier = '';

    /**
     * This is the generator we are using. Defaults to Gravatar.
     * @var string
     */
    private string $generator = 'gravatar';

    /**
     * This is the options array.
     * @var array
     */
    private array $options = [];

    /**
     * Allows you to create Avatar URLs for your users.
     *
     * @param mixed $identifier
     * @param string $generator
     * @param array $options
     */
    public function __construct(mixed $identifier = 'test', string $generator = 'gravatar', array $options = [])
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

    /**
     * Get's the URL for the Avatar
     *
     * @return string
     */
    public function getUrl() : string
    {
        switch ($this->generator)
        {
            case "gravatar":
                $url = $this->usegravatar();
                break;
            case "uiavatars":
                $url = $this->useuiavatars();
                break;
            default:
                throw new GeneratorTypeNotFound('Generator: ' . $this->generator . ' is not a valid option.');
                break;
        }

        return $url;
    }

    /**
     * Creates a new instance of Avatar. Is recommended to use this in Laravel.
     *
     * @param mixed $identifier
     * @param string $generator
     * @param array $options
     * @return void
     */
    public function create(mixed $identifier = '', string $generator = '', array $options = []) {
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

        if($generator == ''){
            $this->generator = config('avatar.default-generator', 'gravatar');
        }
        else{
            $this->generator = $generator;
        }


        $this->options = $options;
    }

    public function CreateUsingUser(User $user, mixed $column = 'email', string $generator = '', array $options = []){
        $identifier = $user->$column;

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

        if($generator == ''){
            $this->generator = config('avatar.default-generator', 'gravatar');
        }
        else{
            $this->generator = $generator;
        }


        $this->options = $options;
    }

    /**
     * Switches the Generator to Gravatar
     *
     * @return self
     */
    public function gravatar() : self
    {
        $this->generator = 'gravatar';

        return $this;
    }

    /**
     * Switches the Generator to UI Avatars
     *
     * @return self
     */
    public function uiavatars() : self
    {
        $this->generator = 'uiavatars';
        
        return $this;
    }

    /**
     * Addes or overwrites an option.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function option(string $key, mixed $value) : self
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * Adds or overwrites multiple options.
     *
     * @param array $options
     * @return self
     */
    public function options(array $options) : self
    {
        foreach ( $options as $key => $value )
        {
            $this->options[$key] = $value;
        }

        return $this;
    }

    /**
     * Resets the options array. If an array is added as it's parameter, it will be the new options array.
     *
     * @param array $options
     * @return self
     */
    public function resetOptions(array $options = []) : self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get's the options array.
     *
     * @return array
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * Changes the identifier.
     *
     * @param string $identifier
     * @return self
     */
    public function newIdentifier(string $identifier) : self
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * This function generates the Gravatar URL
     *
     * @return string
     */
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

    /**
     * This function generates the UI Avatars URL
     *
     * @return string
     */
    private function useuiavatars() : string
    {
        $url = 'https://ui-avatars.com/api/?name=' . urlencode($this->identifier);

        if( array_key_exists( 'background', $this->options ) )
        {

            $url .='&background=' . $this->options['background'];

        }

        if( array_key_exists( 'color', $this->options ) )
        {

            $url .= '&color=' . $this->options['color'];

        }

        if( array_key_exists( 'size', $this->options ) )
        {

            $url = $url . '&size=' . $this->options['size'];

        }

        if( array_key_exists( 'font_size', $this->options ) )
        {

            $url = $url . '&font-size=' . $this->options['font_size'];

        }

        if( array_key_exists( 'length', $this->options ) )
        {

            $url = $url . '&length=' . $this->options['length'];

        }

        if( array_key_exists( 'rounded', $this->options ) )
        {

            $url = $url . '&rounded=' . $this->options['rounded'];

        }

        if( array_key_exists( 'bold', $this->options ) )
        {

            $url = $url . '&bold=' . $this->options['bold'];

        }

        if( array_key_exists( 'format', $this->options ) )
        {

            $url = $url . '&format=' . $this->options['format'];

        }
    
        return $url;
    }
}