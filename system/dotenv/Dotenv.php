<?php

namespace Dotenv;

/**
 * Dotenv.
 *
 * Loads a `.env` file in the given directory and sets the environment vars.
 */
class Dotenv
{
    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath;

    /**
     * The loader instance.
     *
     * @var \Dotenv\Loader|null
     */
    protected $loader;

    public function __construct($path, $file = '.env')
    {
        if ($file == '.env') {
            $file = '.env.' . strtolower(ENVIRONMENT);
        }
        $this->filePath = $this->getFilePath($path, $file);
    }

    /**
     * Load `.env` file in given directory.
     *
     * @return void
     */
    public function load()
    {
        $this->loader = new Loader($this->filePath, $immutable = true);

        return $this->loader->load();
    }

    /**
     * Load `.env` file in given directory.
     *
     * @return void
     */
    public function overload()
    {
        $this->loader = new Loader($this->filePath, $immutable = false);

        return $this->loader->load();
    }

    /**
     * Returns the full path to the file ensuring that it's readable.
     *
     * @param string $path
     * @param string $file
     *
     * @return string
     */
    protected function getFilePath($path, $file)
    {
        if (!is_string($file)) {
            $file = '.env';
        }

        $filePath = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$file;

        return $filePath;
    }

    /**
     * Required ensures that the specified variables exist, and returns a new Validation object.
     *
     * @param mixed $variable
     *
     * @return \Dotenv\Validator
     */
    public function required($variable)
    {
        return new Validator((array) $variable, $this->loader);
    }
    public function setEnvironmentValue($envKey, $envValue)
   {
        $response['estatus'] = false;
        $response['mensaje'] = 'No fue posible actualizar las variables de entorno.';
        $envFile = $this->filePath;
        $str = file_get_contents($envFile);
        $str .= "\n"; #Previene la ultima variable del archivo .env que no contiene salto de linea al final
		$keyPosition = strpos($str, "{$envKey}=");
		$endOfLinePosition = strpos($str, "\n", $keyPosition);
		$oldValue = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
		if (is_bool($keyPosition) && $keyPosition === false) {
            $str .= "{$envKey}={$envValue}";
            $str .= "\n\n";
        } else {
            $str = str_replace($oldValue, "{$envKey}={$envValue}", $str);
        }
		$str = substr($str, 0, -1);
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
        if (file_put_contents($envFile, $str)) {
            $this->overload();
            $response['estatus'] = true;
            $response['mensaje'] = 'Variable actualizada.';
        }
        return $response;
   }
}
