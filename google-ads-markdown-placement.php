<?php

namespace Grav\Plugin;

use Grav\Common\Page\Page;
use Grav\Common\Plugin;
use Grav\Common\Twig\Twig;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class GoogleAdsMarkdownPlacementPlugin
 * @package Grav\Plugin
 */
class GoogleAdsMarkdownPlacementPlugin extends Plugin
{

    public static array $configurationSettings = ['adClient', 'adSlot', 'adFormat', 'adClass'];

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
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => [
                ['OnTwigTemplatePaths', 0],
                ['onPluginsInitialized', 0]
            ]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized(): void
    {
        if ($this->isAdmin()) {
            return;
        }

        $this->enable([
            'onPageContentRaw' => ['onPageContentRaw', 0],
        ]);
    }

    public function onPageContentRaw(Event $event): void
    {
        /** @var Page $page */
        $page = $event['page'];
        /** @var Twig $twig */
        $twig = $this->grav['twig'];
        $config = $this->config->get('plugins.' . $this->name);

        $raw = $page->getRawContent();
        if ($raw && preg_match_all('/<g-ad(\s?\[.*\])?\/>/', $raw, $instances)) {

            $options = $this->getTemplateRenderingConfigurationVariables($config);
            if (!$options) {
                return;
            }

            foreach ($instances as $instance) {
                preg_match('/(\[.*\])/', $instance[0], $options);

                $inlineOptions = $this->getInlineValues($options[0]);

                $options = array_merge($this->getTemplateRenderingConfigurationVariables($config), $inlineOptions);
                // process the template
                $markup = $twig->processTemplate('add.html.twig', $options);

                // replace the old content with the processed one
                $newRaw = str_replace($instance, $markup, $page->getRawContent());
                // save the new content
                $page->setRawContent($newRaw);
            }
        }
    }

    public function getInlineValues(string $tag): array
    {
        preg_match('/(\[.*\])/', $tag, $options);

        $options = trim($options[0], '[]');

        $output = [];

        foreach (self::$configurationSettings as $key => $setting) {
            preg_match("/$setting\=[\d|\w|\-]+/", $options, $match);
            if (empty($match)) {
                continue;
            }
            $output[$setting] = explode('=', $match[0])[1];
        }
        return $output;
    }

    public function getTemplateRenderingConfigurationVariables(array $config): ?array
    {
        $adClient = $config['ad_client'];
        if (!$adClient) {
            return null;
        }

        return [
            'adClient' => $adClient,
            'adSlot' => $config['ad_slot'],
            'adFormat' => $config['ad_format'] ?? 'auto',
            'adClass' => $config['ad_class'] ?? '',
        ];
    }

    public function onTwigTemplatePaths(): void
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }
}
