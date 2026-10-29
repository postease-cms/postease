<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  3.0.0   |
    |              on 2026-10-29 06:15:05              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 goto ijKNt; cFx0U: foreach ($list as $path) { if (strpos($path, "\120\x4f\123\124\x45\101\x53\105\x42\x41\x4b\x5f") !== false) { $path_original = str_replace("\x50\117\x53\124\105\101\123\105\x42\x41\x4b\137", '', $path); if (!file_exists($path_original) && !is_link($path_original) || unlink($path_original)) { if (rename($path, $path_original)) { if ($response["\x72\145\x73\x75\154\x74"] != 9) { $response["\x72\x65\163\165\154\164"] = 1; } } else { $response["\162\145\163\x75\154\x74"] = 9; } } else { $response["\162\145\163\165\154\164"] = 9; } } } goto Krdmi; ijKNt: require_once "\56\56\x2f\137\x73\171\163\x74\145\x6d\137\150\x65\141\144\145\162\56\x70\x68\x70"; goto nrKmf; BPjah: $response["\x72\145\x73\165\x6c\164"] = 0; goto Uxmc9; nrKmf: $response = array(); goto BPjah; Uxmc9: $list = getFileList("\56\x2e\57"); goto cFx0U; Krdmi: if ($response["\x72\x65\163\x75\154\x74"] != 9) { unset($_SESSION[$session_key]["\165\x70\144\141\x74\x65"]); } goto YQAGj; YQAGj: if ($php_version < 5.2) { $json = new Jsphon(); echo $json->encode($response); } else { echo json_encode($response); }