<?php
include 'KMP.php';
include 'Snippet.php';
include 'Highlighter.php';

function search($search_query, $articles, &$elapsed_time)
{
    $KMP = new KMP();
    $snippet = new Snippet();
    $highlighter = new Highlighter();
    $results = [];
    
    foreach ($articles as $article) {
        // Run the search function and measure the elapsed time
        $start = hrtime(true);
        
        $matched_string_position = $KMP->KMPSearch(strtolower($search_query), strtolower($article['isi']), true);

        $end = hrtime(true);
        $elapsed_time += $end - $start;

        if ($matched_string_position) {
            $snippet_text = $snippet->getSnippet($matched_string_position, $article['isi'], $search_query);
            $snippet_text = $highlighter->highlightText($search_query, $snippet_text);

            $results[] = [
                'id' => $article['id'],
                'title' => $article['judul'],
                'description' => $snippet_text,
            ];
        }
    }
    return $results;
}

?>
