<?php

class Snippet {
  public function getSnippet($pos, $string, $keyword) {
      // Get the 35 characters before the keyword
      $startPos = $pos - 35;

      if ($startPos < 0) {
          $startPos = 0;
      } else {
          // If we are in the middle of a word, move back to the nearest word
          $startPos = strrpos(substr($string, 0, $startPos), ' ') + 1;
      }

      // Get the 200 characters after the start position
      $snippet = substr($string, $startPos, 200);

      // If the snippet is too long (i.e. goes beyond the end of the string), trim it
      if (strlen($snippet) == 200) {
          $snippet = substr($snippet, 0, strrpos($snippet, ' '));
      }

      // Add an ellipsis if the snippet is not the whole string
      if ($startPos > 0 || strlen($snippet) < strlen($string)) {
          $snippet .= '...';
      }

      return $snippet;
  }
}

?>