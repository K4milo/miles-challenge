**CHALLENGE FOR CAMILO VANEGAS**

 **1. Describe why you’d want to use a CSS code structure like this:**
```
    div[class^=&#39;button--wrapper--index&#39;],
    div[class*=&#39; button--wrapper--index&#39;] {
        display: none;
    }
```
**A/** Using regular expressions in the selector takes as parameter the class of the div to hide it, that is useful when we want a behavior in classes that share a string of characters.

**2. Describe what you think this Sass mix-in is used for:**
```
    @mixin unknown-mixin {
    	position: absolute !important;
    	height: 1px;
    	width: 1px;
    	overflow: hidden;
    	clip: rect(1px, 1px, 1px, 1px);
    	word-wrap: normal;
    }
```
**A/** I would use this mixin to visually hide DOM elements.

**3. Describe what is going on in this bit of Sass code, and what the data structures might
look like:**
```
    @each $pattern, $size in $patterns {
    	&.pattern-#{$pattern} .paragraph--type--editorial-content-item::after {
	    	background-image: image-url('patterns/#{$pattern}-white.svg';);
    	}
    }
```
**A/** Patterns are used to simplify code routines, in this case the patterns list is being trimmed to place a background image in the child .paragraph--type--editorial-content-item according to the parent pattern, which would result in something like this
```
    .pattern-#pattern1 .paragraph--type--editorial--editorial-content-item::after {
    	  background-image: image-url('patterns/pattern1-white.svg';);
     }

    .pattern-#pattern2 .paragraph--type--editorial--editorial--content-item::after {
    	  background-image: image-url('patterns/pattern2-white.svg';);
     }

    .pattern-#pattern3 .paragraph--type--editorial--editorial-content-item::after {
    	  background-image: image-url('patterns/pattern3-white.svg';);
     }
```
**4. Describe what is going on in this bit of Twig code:**
```
    {% for month in 1..12 %}
      {% set date = month ~ '/1/' ~ 'now'|date('Y') %}
      {% set active = '' %}
      {% for amenity in amenities %}
        {% if date|date('F') == amenity.amenity.name or amenity.amenity.name == 'All Year' %}
          {% set active = 'active' %}
        {% endif %}
      {% endfor %}

      <option value="{{ date|date('m') }}"; class="{{ active }}" {{ date|date('M')|first }}</option>
    {% endfor %}
```
**A/** The objective of this twig is to popularize a dropdown menu <select></select> with a series of dates that take into account some conditionals according to the object amenities, this is how it is constructed:

- The months of the year are iterated in a hardcoded list.
 - The initial validation setting is made with an empty active class variable and a date variable that takes into account the current    date.
 - Iterate the amenities object to reassign the date and active variables that will be used in the construction of the <option>.
 - The option markup is created taking into account the validations applied according to the amenities item.

**5. What is missing from this JS/jQuery code?**
```
    'use strict';
    (function($, Drupal, window, document, undefined) {
      Drupal.behaviors.mmg8VideoPlayer = {
        attach: function(context, settings) {
          var tag = document.createElement('script');
          tag.src = "
          https: //www.youtube.com/iframe_api";
           var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

          function youtube_parser(url) {
           var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&amp;v=)([^#\&amp;\?]*).*/;
           var match = url.match(regExp);
           if (match & & match[2].length == 11) {
            return match[2];
           } else {}
          }

          function onPlayerReady(event) {
           event.target.playVideo();
          }

          function onPlayerStateChange(event) {
           if (event.data == YT.PlayerState.ENDED) {
            event.target.destroy();
           }
          }
          $('.component--video-player', context).each(function() {
             var parentID = $(this).attr('data-entity-id');
             var slidesDiv = '.mmg8-videoshow--slides-' + parentID;
             if (typeof drupalSettings.mmg8_videoshow !== " undefined ") {
              $.each(drupalSettings.mmg8_videoshow.mmg8_videoshow.videos,
                function(index, video) {
                 var player;
                 $('# youtube - player - container - ' + video.paragraphId).on(' click ', function() {
                  player = new YT.Player('youtube-player-container-' + video.paragraphId, {
                   height: $(this).height(),
                   width: $(this).width(),
                   playerVars: {
                    rel: 0
                   },
                   videoId: video.videoUrl,
                   events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                   }
                  });
                 });
                 $('# upload - player - container - ' + video.paragraphId + ' img ').click(function() {
                    var videoSrc = '<video controls autoplay&gt;<source src= " ' + video.uploadUrl + ' " type = " video / mp4 " > & lt; /
                    video & gt; & #39;;
                      $(this).parent().html(videoSrc);
                    });
                }); initSlick(parentID, slidesDiv);
            }
          });
      }
    }
    };
    })(jQuery, Drupal, this, this.document);
```
**A/** I was able to find two things
- There is no fallback in the else that evaluates the regular expression, if the condition is not met the script should have a safe exit and an error report.

- The initSlick() object is not instantiated but if it is invoked, it should be in a const.

**6. Describe what this PHP code does, and what other code or actions do you need to make
it useful?**
```
     function my_module_entity_extra_field_info() {
      $extra = [];
      foreach (NodeType::loadMultiple() as $bundle) {
        $type = $bundle->Id();
        if (in_array($type, valid_types())) {
          foreach (extra_fields($type) as $field = $description) {
            $extra['node'][$type]['display'][$field] = [
              'label' = $description,
              'description' = $description,
              'weight' = 100,
              'visible' = FALSE,
            ];
          }
        }
      }
      return $extra;
    }
```
**A/** This code implements the `hook_entity_extra_field_info()` exposes "pseudo-field" components on content entities.

Field UI's "Manage fields" and "Manage display" pages let users re-order fields, but also non-field components. For nodes, these include elements exposed by modules through hook_form_alter(), for instance.

Content entities or modules that want to have their components supported should expose them using this hook. The user-defined settings (weight, visible) are automatically applied when entities or entity forms are rendered.

For make it usable we need to add the namespace and doing those fields visible:
```
    use Drupal\node\Entity\NodeType;

    /**
     * Implements hook_entity_extra_field_info().
     */
    function my_module_entity_extra_field_info() {
      $extra = [];
      foreach (NodeType::loadMultiple() as $bundle) {
        $type = $bundle->Id();
        if (in_array($type, valid_types())) {
          foreach (extra_fields($type) as $field = $description) {
            $extra['node'][$type]['display'][$field] = [

              'label' = $description,
              'description' = $description,
              'weight' = 100,
              'visible' = TRUE,
            ];
          }
        }
      }
      return $extra;
    }
```
**7. What is wrong with this code, consider PHP, Drupal 9 API, coding depecations,
standards and best practices:**

```
      protected function stringToTime($form_state) {
        return [
          'from_date' => strtotime($form_state->getValue('from_date')),
          'to_date' => strtotime($form_state->getValue('to_date')),
        ];
      }

      public function formValidate(array $form,
      FormStateInterface $form_state) {
        $ts_times = $this->stringToTime($form_state);
        if ($ts_times['from_date'] > $ts_times['to_date']) {
          $form_state->setErrorByName('bad_date', t('"From" date can not be after "To"
    date.'));
        }
        $current_time = $_SERVER['REQUEST_TIME'];
        if ($ts_times['to_date'] > $current_time) {
          $this->messenger()->addStatus('"To" date can not be after Today\'s date.');
        }
      }
  ```
**A/**
- We need to add the namespace reference `use Drupal\Core\Form\FormStateInterface;`
- The validation needs to be called in this format

```
public function validateForm(array &$form, FormStateInterface $form_state) {
  parent::validateForm($form, $form_state);
  if ($plugin = $this
    ->getPlugin()) {
    $ts_times = $this->stringToTime($form_state);
    if ($ts_times['from_date'] > $ts_times['to_date']) {
      $form_state->setErrorByName('bad_date', t('"From" date can not be after "To"
date.'));
    }
    $current_time = $_SERVER['REQUEST_TIME'];
    if ($ts_times['to_date'] > $current_time) {
      $this->messenger()->addStatus('"To" date can not be after Today\'s date.');
    }
  }
}
```
