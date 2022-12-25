<?php
class KMP{
    function KMPSearch($pat, $txt, $firstOnly)
    {
        $result = array();
        $M = strlen($pat);
        $N = strlen($txt);
     
        $lps=array_fill(0,$M,0);
     
        $this->computeLPSArray($pat, $M, $lps);
     
        $i = 0; 
        $j = 0; 
        while (($N - $i) >= ($M - $j)) {
            if ($pat[$j] == $txt[$i]) {
                $j++;
                $i++;
            }
     
            if ($j == $M) {
                if($firstOnly) {
                    return $i - $j;
                    break;
                };
                array_push($result, $i - $j);
                $j = $lps[$j - 1];
            }
     
            else if ($i < $N && $pat[$j] != $txt[$i]) {
                if ($j != 0)
                    $j = $lps[$j - 1];
                else
                    $i = $i + 1;
            }
        }
        return $result;
    }
     
    function computeLPSArray($pat, $M, &$lps)
    {
        $len = 0;
        $lps[0] = 0;
        $i = 1;

        while ($i < $M) {
            if ($pat[$i] == $pat[$len]) {
                $len++;
                $lps[$i] = $len;
                $i++;
            }
            else
            {
                if ($len != 0) {
                    $len = $lps[$len - 1];
                }
                else 
                {
                    $lps[$i] = 0;
                    $i++;
                }
            }
        }
    }
}
?>
