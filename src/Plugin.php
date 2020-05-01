<?php
/**
 * Starfield plugin for Craft CMS
 *
 * Adds a simple star rating field.
 *
 * @link https://www.oberon.nl/
 * @copyright Copyright (c) Oberon
 * @license MIT
 */

namespace oberon\starfield;

use craft\base\Element;
use craft\elements\Entry;
use craft\events\RegisterElementSortOptionsEvent;
use oberon\starfield\fields\StarField;

use Craft;
use \craft\services\Fields;
use \craft\events\RegisterComponentTypesEvent;
use yii\base\Event;

/**
 * Simple Text plugin
 */
class Plugin extends \craft\base\Plugin
{
    /**
     * @inheritdoc
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var Plugin
     */
    public static $plugin;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register our fields
        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = StarField::class;
            }
        );

        Event::on(Entry::class, Element::EVENT_REGISTER_SORT_OPTIONS, function(RegisterElementSortOptionsEvent $event) {
            $event->sortOptions[] = [
                'label' => '<FieldName>',
                'orderBy' => 'field_<FieldHandle>',
                'attribute' => 'field:<FieldID>'
            ];
        });

        Craft::info(
            'starfield plugin loaded',
            __METHOD__
        );
    }

}
