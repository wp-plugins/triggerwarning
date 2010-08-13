<?php
/**
Plugin Name: Trigger Warning
Plugin URI: http://wordpress.org/extend/plugins/triggerwarning/
Description: Wrap the trigger content in <strong>[trigger][/trigger]</strong> to hide it. Example: [trigger]something terrible[/trigger]  If you want to specify the type of trigger, you can do something like <strong>[trigger warning="violent imagery"]</strong>something terrible<strong>[/trigger]</strong>. Readers can choose to read the trigger content by clicking on the "Show" button.
Author: Zing-Ming
Version: 1.0
Author URI: http://wordpress.org/extend/plugins/profile/zingming
*/

class TriggerWarning {
      const shortcodeName = "trigger";

      function TriggerWarning () {
      	       $this->__construct();
      }

      function __construct () {
      	       add_shortcode(self::shortcodeName, array($this, 'runShortcode'));
	       add_action('admin_head', array($this, 'addToAdminHead'));
      }

      function runShortcode ($atts = null, $content = null) {
      	       extract(shortcode_atts(array(
			'warning' => '',
	       ), $atts));
 
	       return $this->getOpeningHtmlTags($warning) . $content . $this->getClosingHtmlTags();
      }

      function getOpeningHtmlTags ($warning) {
      	       return "<div>\n" . $this->getDescription($warning) . '<input type="button" value="Show" style="width:60px;margin:0px;padding:0px;font-variant:small-caps;" onclick="' . $this->getOnClickJS() . '" />' . "\n" . '<div style="display:none;">';
      }

      function getClosingHtmlTags () {
      	      return "</div>\n</div><br />\n";
      }

      function getOnClickJS () {
      	       return "var noise = this.parentNode.getElementsByTagName('div')[0]; if (noise.style.display == 'none') { noise.style.display = ''; noise.style.paddingTop='1em'; this.value = 'Hide';} else { noise.style.display = 'none'; this.value = 'Show'; }";
      }

      function getDescription ($warning) {
      	       if ($warning == '')
	       {
			return "<strong>Trigger Warning</strong> &nbsp; ";
	       }
	       else
	       {
			return "<strong>Trigger Warning:</strong> {$warning} &nbsp; ";
	       }
      }

      function addToAdminHead () {
      	       echo '<script type="text/JavaScript" src="' . WP_PLUGIN_URL .'/'. plugin_basename(dirname(__FILE__)) . '/triggerquicktag.js"></script>' . "\n";
      }
}

$triggerwarning = new TriggerWarning();

?>
