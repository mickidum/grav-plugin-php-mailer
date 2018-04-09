<?php
namespace Grav\Plugin;

use Grav\Common\Config\Config;
use Grav\Common\Grav;
use Grav\Common\Plugin;
use Grav\Common\Twig\Twig;
use Grav\Plugin\PHPemail\PHPemail;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class PHPMailerPlugin
 * @package Grav\Plugin
 */
class PHPMailerPlugin extends Plugin
{
    /**
     * @var Email
     */
    protected $email;

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onFormProcessed' => ['onFormProcessed', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        require_once __DIR__ . '/classes/PHPemail.php';
    }

    
    /**
     * Send email when processing the form data.
     *
     * @param Event $event
     */
    public function onFormProcessed(Event $event)
    {
        $form = $event['form'];
        $action = $event['action'];
        $params = $event['params'];

        switch ($action) {
            case 'phpemail':
                // Prepare Twig variables
                $vars = array(
                    'form' => $form
                );
                
                $grav = Grav::instance();
                $grav->fireEvent('onEmailSend', new Event(['params' => &$params, 'vars' => &$vars]));

                // Build message
                $message = $this->buildMessage($params, $vars);

                $this->email = new PHPemail($message);

                $this->email->send();

                break;
        }
    }

    /**
     * Build e-mail message.
     *
     * @param array $params
     * @param array $vars
     * @return array $message
     */
    protected function buildMessage(array $params, array $vars = array())
    {

        /** @var Twig $twig */
        $twig = $this->grav['twig'];

        // Extend parameters with defaults.
        $params += array(
            'body' => $this->config->get('plugins.php-mailer.body', '{% include "forms/data.txt.twig" %}'),
            'from' => $this->config->get('plugins.php-mailer.from'),
            'from_name' => $this->config->get('plugins.php-mailer.from_name'),
            'subject' => !empty($vars['form']) && $vars['form'] instanceof Form ? $vars['form']->page()->title() : null,
            'to' => $this->config->get('plugins.php-mailer.to'),
            'to_name' => $this->config->get('plugins.php-mailer.to_name'),
            'process_markdown' => false,
        );

        // Create message object.
        $message = [];


        if (!$params['to']) {
            throw new \RuntimeException($this->grav['language']->translate('PLUGIN_EMAIL.PLEASE_CONFIGURE_A_TO_ADDRESS'));
        }
        if (!$params['from']) {
            throw new \RuntimeException($this->grav['language']->translate('PLUGIN_EMAIL.PLEASE_CONFIGURE_A_FROM_ADDRESS'));
        }
        
        
        // Process parameters.
        foreach ($params as $key => $value) {

            switch ($key) {
                
                case 'body':
                    if (is_string($value)) {
                        $body = $twig->processString($value, $vars);

                        if ($params['process_markdown']) {
                            $parsedown = new \Parsedown();
                            $body = $parsedown->text($body);
                        }

                        $message['body'] = trim($body);
                    }
                    
                    break;

                case 'from':
                    if (is_string($value) && !empty($params['from_name'])) {
                        $value = array(
                            'mail' => $twig->processString($value, $vars),
                            'name' => $twig->processString($params['from_name'], $vars),
                        );
                    }

                    else {
                        $value = array(
                            'mail' => $twig->processString($value, $vars),
                            'name' => Grav::instance()['config']->get('site.title')
                        );
                    }

                    $message['from'] = $value;
                    
                    break;

                case 'subject':
                    $message['subject'] = $twig->processString($this->grav['language']->translate($value), $vars);
                    break;

                case 'to':
                    if (is_string($value) && !empty($params['to_name'])) {
                        $value = array(
                            'mail' => $twig->processString($value, $vars),
                            'name' => $twig->processString($params['to_name'], $vars),
                        );
                    }
                    else {
                        $value = array(
                            'mail' => $twig->processString($value, $vars),
                            'name' => Grav::instance()['config']->get('site.author.name')
                        );
                    }
                        
                    $message['to'] = $value;
                    break;
            }
        }

        return $message;
    }

}
