<?php
class Highlighter
{
    private $KMP;

    public function __construct()
    {
        $this->KMP = new KMP();
    }

public function highlightText($keywords, $text)
    {
        $highlightedText = '';
        $keywordPositions = $this->KMP->KMPSearch(strtolower($keywords), strtolower($text), false);
        $currentTextPosition = 0;
        foreach ($keywordPositions as $keywordPosition) {
            // Get the original case of the keyword from the original text
            $originalCaseKeyword = substr($text, $keywordPosition, strlen($keywords));
            // Concatenate the highlighted text so far with a slice of the original text
            // from the current position to the location of the keyword,
            // and then add the keyword in bold tags
            $highlightedText .= substr($text, $currentTextPosition, $keywordPosition - $currentTextPosition) . "<b style='color: #0d6efd;''>{$originalCaseKeyword}</b>";
            // Update the current text position to the position immediately after the keyword
            $currentTextPosition = $keywordPosition + strlen($keywords);
        }
        // Concatenate the highlighted text with the remainder of the original text
        $highlightedText .= substr($text, $currentTextPosition);
        return $highlightedText;
    }
}
?>
