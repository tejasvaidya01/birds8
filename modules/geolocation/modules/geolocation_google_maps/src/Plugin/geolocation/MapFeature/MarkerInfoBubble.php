<?php

namespace Drupal\geolocation_google_maps\Plugin\geolocation\MapFeature;

use Drupal\geolocation\MapFeatureBase;
use Drupal\Core\Render\BubbleableMetadata;

/**
 * Provides marker infobubble.
 *
 * @MapFeature(
 *   id = "marker_infobubble",
 *   name = @Translation("Marker InfoBubble"),
 *   description = @Translation("Open InfoBubble on Marker click."),
 *   type = "google_maps",
 * )
 */
class MarkerInfoBubble extends MapFeatureBase {

  /**
   * {@inheritdoc}
   */
  public static function getDefaultSettings() {
    return [
      'close_button' => FALSE,
      'close_other' => TRUE,
      'close_button_src' => '',
      'shadow_style' => 0,
      'padding' => 10,
      'border_radius' => 8,
      'border_width' => 2,
      'border_color' => '#039be5',
      'background_color' => '#fff',
      'min_width' => '',
      'max_width' => '550',
      'min_height' => '',
      'max_height' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getSettingsForm(array $settings, array $parents) {
    $settings = $this->getSettings($settings);

    $form['close_button'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show a close button in the right upper corner of the infobubble'),
      '#description' => $this->t('This button closes the tooltip.'),
      '#default_value' => $settings['close_button'],
    ];
    $form['close_other'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Close other infobubbles when opening this one'),
      '#description' => $this->t('Before opening this infobubble closes the others'),
      '#default_value' => $settings['close_other'],
    ];
    $form['close_button_src'] = [
      '#type' => 'textfield',
      '#title' => $this->t('URL for the close button'),
      '#description' => $this->t('A 12x12 pixel image'),
      '#default_value' => $settings['close_button_src'],
    ];
    $form['shadow_style'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Change shadow style'),
      '#description' => $this->t('Allow the user to switch the shadow style'),
      '#default_value' => $settings['shadow_style'],
    ];
    $form['padding'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Padding'),
      '#description' => $this->t('Change padding.'),
      '#default_value' => $settings['padding'],
    ];
    $form['border_radius'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Border radius'),
      '#description' => $this->t('Change border radius'),
      '#default_value' => $settings['border_radius'],
    ];
    $form['border_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Border width'),
      '#description' => $this->t('Change border width.'),
      '#default_value' => $settings['border_width'],
    ];
    $form['border_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Border color'),
      '#description' => $this->t('Change border color.'),
      '#default_value' => $settings['border_color'],
    ];
    $form['background_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Background color'),
      '#description' => $this->t('Change background color.'),
      '#default_value' => $settings['background_color'],
    ];
    $form['min_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Minimum width'),
      '#description' => $this->t('Change Minimum width.'),
      '#default_value' => $settings['min_width'],
    ];
    $form['max_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Maximum width'),
      '#description' => $this->t('Change maximum width.'),
      '#default_value' => $settings['max_width'],
    ];
    $form['min_height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Minimum height'),
      '#description' => $this->t('Change minimum height.'),
      '#default_value' => $settings['min_height'],
    ];
    $form['max_height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Maximum height'),
      '#description' => $this->t('Change maximum height.'),
      '#default_value' => $settings['max_height'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function alterMap(array $render_array, array $feature_settings, array $context = []) {
    $render_array = parent::alterMap($render_array, $feature_settings, $context);

    $feature_settings = $this->getSettings($feature_settings);

    $render_array['#attached'] = BubbleableMetadata::mergeAttachments(
      empty($render_array['#attached']) ? [] : $render_array['#attached'],
      [
        'library' => [
          'geolocation_google_maps/geolocation.markerinfobubble',
        ],
        'drupalSettings' => [
          'geolocation' => [
            'maps' => [
              $render_array['#id'] => [
                'marker_infobubble' => [
                  'enable' => TRUE,
                  'closeButton' => $feature_settings['close_button'],
                  'closeOther' => $feature_settings['close_other'],
                  'closeButtonSrc' => $feature_settings['close_button_src'],
                  'shadowStyle' => $feature_settings['shadow_style'],
                  'padding' => $feature_settings['padding'],
                  'borderRadius' => $feature_settings['border_radius'],
                  'borderWidth' => $feature_settings['border_width'],
                  'borderColor' => $feature_settings['border_color'],
                  'backgroundColor' => $feature_settings['background_color'],
                  'minWidth' => $feature_settings['min_width'],
                  'maxWidth' => $feature_settings['max_width'],
                  'minHeight' => $feature_settings['min_height'],
                  'maxHeight' => $feature_settings['max_height'],
                ],
              ],
            ],
          ],
        ],
      ]
    );

    return $render_array;
  }

}
