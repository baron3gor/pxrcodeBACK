<?php

/**
 * HTML minify
 */

class PXR_HTML_Compression
{
   protected $pxr_compress_css = true;
   protected $pxr_compress_js = true;
   protected $pxr_info_comment = true;
   protected $pxr_remove_comments = true;
   protected $html;
   public function __construct($html)
   {
      if (!empty($html)) {
         $this->pxr_parseHTML($html);
      }
   }
   public function __toString()
   {
      return $this->html;
   }
   protected function pxr_bottomComment($raw, $compressed)
   {
      $raw = strlen($raw);
      $compressed = strlen($compressed);
      $savings = ($raw - $compressed) / $raw * 100;
      $savings = round($savings, 2);
      return '<!--HTML compressed, size saved ' . $savings . '%. From ' . $raw . ' bytes, now ' . $compressed . ' bytes-->';
   }
   protected function pxr_minifyHTML($html)
   {
      $pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
      preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
      $overriding = false;
      $raw_tag = false;
      $html = '';
      foreach ($matches as $token) {
         $tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
         $content = $token[0];
         if (is_null($tag)) {
            if (!empty($token['script'])) {
               $strip = $this->pxr_compress_js;
            } else if (!empty($token['style'])) {
               $strip = $this->pxr_compress_css;
            } else if ($content == '<!--wp-html-compression no compression-->') {
               $overriding = !$overriding;
               continue;
            } else if ($this->pxr_remove_comments) {
               if (!$overriding && $raw_tag != 'textarea') {
                  $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
               }
            }
         } else {
            if ($tag == 'pre' || $tag == 'textarea') {
               $raw_tag = $tag;
            } else if ($tag == '/pre' || $tag == '/textarea') {
               $raw_tag = false;
            } else {
               if ($raw_tag || $overriding) {
                  $strip = false;
               } else {
                  $strip = true;
                  $content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
                  $content = str_replace(' />', '/>', $content);
               }
            }
         }
         if ($strip) {
            $content = $this->pxr_removeWhiteSpace($content);
         }
         $html .= $content;
      }
      return $html;
   }
   public function pxr_parseHTML($html)
   {
      $this->html = $this->pxr_minifyHTML($html);
      if ($this->pxr_info_comment) {
         $this->html .= "\n" . $this->pxr_bottomComment($html, $this->html);
      }
   }
   protected function pxr_removeWhiteSpace($str)
   {
      $str = str_replace("\t", ' ', $str);
      $str = str_replace("\n",  '', $str);
      $str = str_replace("\r",  '', $str);
      while (stristr($str, '  ')) {
         $str = str_replace('  ', ' ', $str);
      }
      return $str;
   }
}

function pxr_wp_html_compression_finish($html)
{
   return new PXR_HTML_Compression($html);
}

function pxr_wp_html_compression_start()
{
   ob_start('pxr_wp_html_compression_finish');
}
// add_action('get_header', 'pxr_wp_html_compression_start');
