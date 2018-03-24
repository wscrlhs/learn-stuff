<?php
class Configuration
{
    /**
     * All of the configuration items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new configuration repository
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Get the specified configuration value
     *
     * @param $key
     * @return null
     */
    public function get($key)
    {
        return isset($this->items[$key]) ? $this->items[$key] : null;
    }


    /**
     * set a given configuration value
     * @param $key
     * @param null $value
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];
        foreach ($keys as $key => $value) {
            $this->items[$key] = $value;
        }
    }
}

