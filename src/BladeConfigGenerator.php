<?php

namespace Jijoel\AuthApi;


class BladeConfigGenerator
{
    /**
     * Generate a global javascript variable called config
     *
     * @param  array  $attrs   custom attributes to set
     *
     * @return String
     */
    public function generate($attrs = [])
    {
        $config = json_encode($this->mergeConfig($attrs));

        return <<<EOT
<script type="text/javascript">
window.config = $config
</script>
EOT;
    }

    /**
     * Merge any custom config with the class config
     *
     * @param  Array|array $attrs  custom config values
     *
     * @return Array
     */
    protected function mergeConfig(Array $attrs = [])
    {
        return array_merge($this->config(), $attrs);
    }

    /**
     * Default configuration values sent to Javascript
     *
     * @return Array
     */
    protected function config()
    {
        return [
            'appName' => config('app.name'),
            'locale' => $locale = app()->getLocale(),
            'locales' => config('app.locales'),
        ];
    }
}
