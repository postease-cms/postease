<?php
 goto HKqU_; wfh53: $tinymce_init = file_exists($target_file_init) ? $target_file_init : "\x74\x69\x6e\x79\155\x63\145\57\x74\151\156\x79\x6d\143\145\137\151\156\151\x74\56\x6a\163"; goto gLALX; nc80X: $child_process = isset($_GET["\x63\x68\151\x6c\144\137\x70\162\x6f\143\x65\x73\x73"]) ? $_GET["\x63\x68\x69\154\x64\x5f\160\x72\x6f\x63\145\163\163"] : 0; goto A6rih; r_lCF: $use_category_flg = $posttype_config["\165\163\145\137\x63\141\164\x65\147\x6f\x72\x79\137\x66\x6c\147"]; goto Vyvgd; SynEM: $permalink_date = $publish_datetime; goto OAfRj; Ay0cP: $current_flg = isset($post_base["\x63\x75\x72\162\145\156\164\137\x66\x6c\x67"]) ? $post_base["\x63\x75\162\x72\x65\x6e\164\137\146\154\x67"] : 1; goto Fp7Lp; j945x: $post_pages = array(); goto QWeqg; XiKfl: foreach ($_SESSION[$session_key]["\x63\x6f\155\155\157\x6e"]["\154\x61\156\147\165\141\x67\145\x73"] as $language_id => $value) { foreach ($custom_items as $custom_item_id => $data) { if (isset($posts_custom[$custom_item_id][$language_id])) { $items[$custom_item_id][$language_id] = $posts_custom[$custom_item_id][$language_id]; } else { $items[$custom_item_id][$language_id] = null; } } } goto H3Sjs; jmEM1: $back_link = $process == 12 ? "\x3c\141\40\x68\x72\145\x66\x3d\42\56\x2f\x3f\166\x69\x65\167\x5f\160\141\147\x65\x3d\x70\x6f\x73\164\163\46\x70\162\145\x76\137\151\144\x3d" . $target_id . "\42\76\50\x20" . TXT_POST_LNK_BACKTOLIST . "\x20\x29\x3c\x2f\x61\x3e" : null; goto g6Tod; rhE_c: if (empty($tags_id) && !empty($_SESSION[$session_key]["\x63\157\x6d\155\x6f\x6e"]["\164\141\147\163"]) && !empty($_SESSION[$session_key]["\x70\157\x73\x74\x73"]["\163\143\137\164\141\147\x5f\151\x64"])) { array_push($tags_id, $_SESSION[$session_key]["\x70\157\x73\x74\x73"]["\x73\143\137\164\x61\147\137\151\x64"]); } goto rItJ6; kbjGa: $use_addition_flg = $posttype_config["\165\x73\x65\137\141\x64\x64\151\164\151\157\156\137\146\154\147"]; goto S1707; M0vv9: if (!empty($id) || !empty($parent_id)) { $additional_condition = null; if (!empty($post_base["\x70\x61\x72\x65\x6e\164\x5f\x69\144"])) { $parent_id = $post_base["\160\141\162\145\156\164\137\151\144"]; $target_parent_id = $post_base["\x70\141\x72\145\x6e\x74\137\151\x64"]; $additional_condition = "\117\122\40\151\144\40\x3d\x20{$target_parent_id}\40\117\122\x20\160\x61\162\145\x6e\164\x5f\151\x64\40\x3d\40{$target_parent_id}"; } else { $target_parent_id = $post_base["\151\144"]; } try { $sql = "\xa\11\11\11\x9\x53\105\x4c\x45\103\124\40\x69\144\x2c\x20\x76\x65\x72\x73\x69\157\156\54\x20\x73\164\141\164\165\163\12\x9\11\11\x9\x46\122\117\115\40{$table_prefix}\x70\x6f\163\164\x73\137\142\x61\163\145\12\x9\11\11\11\x57\110\105\x52\105\xa\x9\11\11\11\11\x76\145\162\x73\x69\157\x6e\40\x3d\40{$version}\xa\11\11\x9\x9\x9\101\116\104\x20\x64\145\x6c\145\164\145\137\146\x6c\147\x20\75\40\x30\12\x9\x9\11\x9\11\101\116\104\x20\x28\12\x9\x9\x9\11\x9\11\x69\x64\x20\x3d\x20{$target_id}\xa\11\x9\x9\11\x9\11\x4f\122\40\160\x61\162\x65\x6e\164\137\x69\x64\40\x3d\40{$target_id}\xa\11\x9\x9\x9\11\x9{$additional_condition}\xa\11\11\x9\11\x9\x29\12\x9\x9\x9\11\117\x52\x44\105\x52\40\102\x59\x20\160\x61\x72\145\x6e\164\x5f\x69\144\54\x20\151\x64\40\101\x53\x43\12\11\x9"; $read_post_pages = $pdo->prepare($sql); $read_post_pages->execute(); while ($record = $read_post_pages->fetch(PDO::FETCH_ASSOC)) { switch ($record["\163\164\141\164\165\163"]) { case 1: $label = "\x70\x72\151\x6d\x61\x72\171"; break; case 2: $label = "\167\x61\x72\x6e\x69\x6e\x67"; break; case 8: $label = "\x64\x65\146\141\165\x6c\164"; break; } $record["\154\x61\x62\145\x6c"] = $label; $post_pages[$i_page] = $record; $i_page++; } unset($read_post_pages); } catch (PDOException $e) { $read_error = 4; header("\114\157\143\x61\164\x69\x6f\x6e\72\40\x2e\57\x65\x72\162\x6f\162\56\x70\150\160\77\160\x61\147\x65\75{$page}\46\162\x65\141\144\x5f\145\x72\162\x6f\x72\x3d{$read_error}"); die; } } goto yRriI; ifDAv: $tags_id = !empty($post_base["\164\141\147\137\x69\144"]) ? explode("\x2c", $post_base["\164\141\x67\x5f\151\x64"]) : array(); goto ySYoe; CFcrJ: $publish_flg = 0; goto tWfI4; FFmba: if ($status == 1 && $publish_end_at && strtotime($publish_end_at) < time()) { $label_status = "\x64\145\x66\141\165\x6c\x74"; } goto crrIM; MpiZf: if (file_exists(dirname(__FILE__) . "\57\56\56\57\143\165\x73\x74\157\x6d\57\x70\x6f\x73\x74\57\x70\157\163\x74\x5f" . sprintf("\45\x30\64\x64", $_SESSION[$session_key]["\143\157\155\x6d\x6f\x6e"]["\x74\150\151\x73\x5f\160\157\163\x74\x74\171\x70\x65"]) . "\x2e\160\x68\160")) { include_once dirname(__FILE__) . "\57\56\x2e\x2f\143\165\x73\164\157\155\x2f\x70\157\x73\x74\x2f\160\x6f\x73\x74\x5f" . sprintf("\x25\x30\x34\144", $_SESSION[$session_key]["\143\x6f\x6d\x6d\x6f\156"]["\x74\150\151\x73\137\x70\x6f\163\164\164\x79\x70\145"]) . "\x2e\x70\150\160"; } goto MrK5Z; TR7Pr: $allow_delete_msg = TXT_POST_MSG_ALLOWDELETEPOST; goto x3g2S; MrK5Z: if (!empty($child_process) && $child_process == 11) { $process_msg = TXT_POST_MSG_CHILDNEWPOST; $process_msg_style = "\151\x6e\146\157"; $process_msg_type = "\x44\x6f\156\145"; } goto dwph1; k3PNS: $auto_save_flg = $posttype_config["\x61\x75\164\157\x5f\x73\141\x76\145\x5f\x66\154\147"]; goto G4fxS; k0c2T: $label_addition = !empty($posttype_config["\x6c\141\142\145\x6c\x5f\x61\x64\x64\151\x74\151\157\x6e"]) ? $posttype_config["\154\141\142\145\154\137\141\x64\x64\151\x74\151\157\x6e"] : TXT_POST_LBL_ADDITION; goto Q7ujq; hzOrg: $site_slug = $_SESSION[$session_key]["\x63\x6f\155\155\x6f\x6e"]["\163\x69\x74\x65\x73"][$_SESSION[$session_key]["\143\157\x6d\x6d\x6f\156"]["\164\x68\151\x73\137\163\x69\164\145"]]["\x73\154\x75\x67"]; goto Px46I; Ad1DF: foreach ($tags_id as $key => $value) { $tags[intval($value)] = intval($value); } goto uLBLD; Fp7Lp: $publish_datetime = !empty($post_base["\160\165\x62\154\x69\x73\150\x5f\x64\x61\164\145\164\x69\x6d\x65"]) ? date("\131\x2d\155\x2d\144\x20\110\72\151", strtotime($post_base["\160\165\142\x6c\x69\x73\150\x5f\144\x61\x74\x65\164\151\x6d\145"])) : null; goto klNpS; iu_pK: try { $custom_items = array(); $sql = "\x53\x45\x4c\x45\103\x54\40\52\40\x46\122\117\115\40{$table_prefix}\143\165\163\164\x6f\x6d\x5f\151\164\x65\155\163\40\x57\x48\x45\x52\x45\40\x64\145\x6c\x65\164\145\137\x66\x6c\x67\40\x3d\40\60\40\x41\x4e\104\x20\x73\x74\x61\x74\165\x73\x20\x3d\40\x31\x20\101\x4e\x44\40\x70\157\x73\164\164\171\x70\x65\137\151\144\40\x3d\40{$_SESSION[$session_key]["\x63\x6f\x6d\x6d\157\156"]["\x74\x68\151\x73\137\x70\157\x73\x74\164\171\x70\x65"]}\40\x4f\122\104\105\x52\x20\x42\131\x20\x6c\x69\156\145\x5f\x6f\x72\144\145\162\x20\101\123\x43"; $read_custom_items = $pdo->prepare($sql); $read_custom_items->execute(); while ($custom_item = $read_custom_items->fetch(PDO::FETCH_ASSOC)) { $custom_items[$custom_item["\x69\144"]] = $custom_item; } unset($read_custom_items); } catch (PDOException $e) { $read_error = 1; header("\114\157\x63\141\x74\x69\x6f\x6e\72\40\x2e\x2f\145\162\162\157\162\56\160\x68\x70\77\160\x61\x67\x65\x3d{$page}\46\x72\x65\141\x64\137\x65\162\x72\157\162\x3d{$read_error}"); die; } goto mCFWm; gLALX: $target_file_css = "\143\165\163\164\x6f\x6d\x2f\164\x69\x6e\x79\x6d\143\x65\57\143\163\163\57\160\x6f\x73\x74\x74\x79\x70\x65\x5f" . sprintf("\x25\x30\64\144", $_SESSION[$session_key]["\x63\157\x6d\x6d\157\156"]["\164\150\x69\163\137\x70\x6f\163\x74\x74\171\x70\x65"]) . "\56\143\x73\163"; goto sy3EH; yRriI: if ($create_child_flg) { unset($post_base["\145\171\145\x63\x61\x74\x63\150"]); unset($post_base["\143\162\145\141\x74\x65\144\x5f\x61\x74"]); unset($post_base["\x63\162\145\x61\x74\145\144\137\x62\171"]); unset($post_base["\165\160\144\x61\x74\x65\144\137\x61\x74"]); unset($post_base["\x75\160\x64\141\x74\x65\144\x5f\x62\x79"]); unset($post_base["\x73\x74\x61\x74\x75\x73"]); foreach ($posts_text as $language_id => $row) { unset($posts_text[$language_id]["\x61\144\x64\x69\x74\151\x6f\x6e"]); unset($posts_text[$language_id]["\x63\157\156\164\x65\x6e\x74"]); } $new_page = array("\x69\x64" => 0, "\x73\164\141\164\x75\163" => 2, "\x6c\141\x62\x65\154" => "\x73\165\x63\x63\145\163\163"); $post_pages[$i_page] = $new_page; } goto t2Fm5; fvF7t: $versions_all = array(); goto rzthG; mCFWm: foreach ($custom_items as $key => $row) { if ($row["\x74\x79\x70\x65"] != "\151\x6d\x61\147\145" && $row["\x74\x79\160\x65"] != "\x67\x61\x6c\x6c\x65\162\x79" && $row["\x74\171\160\145"] != "\162\145\154\x61\164\x69\157\156" && $row["\x74\x79\160\x65"] != "\x73\171\156\x74\x61\170" && $row["\x74\171\x70\x65"] != "\x74\x61\142\x6c\145" && !empty($row["\143\x68\x6f\151\143\x65\x73"])) { try { $custom_values = array(); $sql = "\x53\105\x4c\105\x43\124\x20\151\144\40\x46\x52\x4f\115\40{$table_prefix}\x63\x75\163\x74\157\x6d\137\x76\x61\154\165\x65\x73\x5f\142\x61\163\x65\x20\x57\110\105\x52\105\x20\144\x65\x6c\x65\x74\x65\137\146\x6c\x67\40\x3d\40\60\x20\101\116\104\40\x6c\151\x73\164\137\x69\x64\40\x3d\40{$row["\143\150\157\151\x63\x65\x73"]}\x20\117\122\x44\x45\122\x20\x42\131\x20\154\151\156\145\x5f\157\x72\x64\x65\x72\40\x41\123\103\54\40\151\x64\x20\101\123\103"; $read_custom_values = $pdo->prepare($sql); $read_custom_values->execute(); while ($custom_value = $read_custom_values->fetch(PDO::FETCH_ASSOC)) { foreach ($_SESSION[$session_key]["\143\x6f\x6d\x6d\x6f\x6e"]["\154\x61\x6e\147\x75\x61\147\x65\x73"] as $language_id => $value) { $custom_values[$language_id][$custom_value["\x69\x64"]] = array(); } } unset($read_custom_values); foreach ($custom_values as $language_id => $custom_value) { $labels = array(); foreach ($custom_value as $base_id => $array) { $sql = "\123\105\114\105\x43\124\x20\154\141\142\145\x6c\x20\106\x52\x4f\x4d\40{$table_prefix}\x63\x75\x73\164\157\155\x5f\166\x61\154\165\x65\x73\x5f\154\x61\x62\145\x6c\x20\x57\x48\105\122\x45\40\142\x61\x73\x65\137\151\x64\x20\x3d\x20{$base_id}\40\x41\x4e\x44\40\x6c\141\x6e\147\x75\x61\x67\145\137\x69\144\x20\75\40{$language_id}"; $read_labels = $pdo->prepare($sql); $read_labels->execute(); while ($record = $read_labels->fetch(PDO::FETCH_ASSOC)) { $labels[$base_id] = $record["\x6c\141\x62\x65\x6c"]; } $custom_values[$language_id] = $labels; unset($read_records); } } $custom_items[$key]["\143\150\157\x69\143\145\163"] = $custom_values; } catch (PDOException $e) { $read_error = 2; header("\114\157\x63\x61\x74\x69\x6f\156\x3a\x20\x2e\x2f\145\162\162\157\162\x2e\x70\150\160\77\x70\x61\147\145\75{$page}\x26\162\x65\x61\144\137\145\x72\x72\x6f\162\x3d{$read_error}"); die; } } if ($row["\x74\x79\160\x65"] == "\x72\145\154\141\x74\151\x6f\x6e") { $relation_posts[$key] = array(); $sql = "\x53\x45\114\105\103\x54\x20\160\142\56\x69\144\54\40\x70\x74\x2e\164\151\164\x6c\x65\54\40\160\x62\x2e\160\165\x62\154\151\x73\150\137\144\141\x74\x65\x74\x69\x6d\145\x20\106\x52\117\115\x20{$table_prefix}\160\157\163\x74\x73\x5f\142\141\163\x65\x20\x41\123\40\160\142\xa\x9\x9\x9\11\x9\x9\x9\114\x45\106\124\x20\x4f\x55\124\105\122\40\112\117\111\x4e\x20{$table_prefix}\160\x6f\x73\x74\163\137\x74\145\170\x74\x20\x41\x53\x20\x70\x74\xa\11\11\x9\11\11\11\x9\11\x4f\116\x20\x70\x62\56\151\144\40\x3d\x20\160\164\x2e\142\x61\x73\145\137\x69\144\12\11\11\x9\x9\11\11\127\x48\x45\122\105\x20\x70\x62\x2e\144\x65\154\145\164\145\x5f\146\x6c\147\x20\x3d\x20\60\40\101\116\x44\40\x70\x62\x2e\160\157\x73\164\164\171\x70\145\x5f\151\x64\x20\x3d\40{$row["\143\x68\x6f\x69\x63\x65\x73"]}\40\x41\x4e\104\40\160\142\56\x69\144\40\x3c\76\x20{$id}\x20\x4f\x52\104\x45\x52\40\102\x59\x20\x70\x62\56\160\x75\x62\x6c\x69\x73\150\x5f\144\x61\164\x65\164\151\x6d\145\40\104\105\x53\103"; $read_posts = $pdo->prepare($sql); $read_posts->execute(); while ($record = $read_posts->fetch(PDO::FETCH_ASSOC)) { $relation_posts[$key][$record["\151\x64"]] = $record["\164\151\x74\x6c\145"]; } unset($read_posts); } } goto fvF7t; h4T1w: if (!empty($id)) { $target_id = $id; } elseif (empty($id) && !empty($parent_id)) { $target_id = $parent_id; } goto MXfcX; NpE8V: foreach ($_SESSION[$session_key]["\143\157\155\155\x6f\x6e"]["\143\141\164\145\x67\157\x72\151\145\x73"] as $key => $values) { if ($values["\160\x61\x72\x65\x6e\164\137\x69\x64"] == 0) { $formated_categories[$key] = $values; } else { $formated_categories[$values["\160\x61\x72\x65\156\x74\137\151\x64"]]["\x63\x68\x69\x6c\x64\162\145\156"][$key] = $values; } } goto TR7Pr; HKqU_: $id = isset($_GET["\x69\x64"]) ? $_GET["\151\x64"] : 0; goto nC5q1; u7SOa: $versioned_at = !empty($post_base["\166\x65\162\x73\x69\157\x6e\145\144\137\x61\164"]) ? $post_base["\x76\145\x72\x73\x69\157\x6e\x65\144\x5f\141\164"] : date("\131\x2d\155\x2d\x64\x20\x48\72\151\72\163"); goto Ay0cP; e18D7: $eyecatch = !empty($post_base["\x65\171\x65\143\141\164\x63\x68"]) ? $post_base["\145\171\145\x63\141\164\143\150"] : null; goto IBjst; S1707: $use_content_flg = $posttype_config["\165\x73\145\x5f\x63\x6f\156\x74\x65\x6e\x74\137\x66\154\147"]; goto aMzUq; HFeOY: $parent_id = isset($_GET["\160\x61\x72\x65\x6e\x74\x5f\x69\144"]) ? $_GET["\x70\x61\x72\145\x6e\x74\x5f\x69\144"] : 0; goto RQypQ; uGCrI: $this_posttype = isset($_GET["\x74\150\151\x73\x5f\160\x6f\163\164\x74\x79\x70\x65"]) ? $_GET["\164\x68\x69\163\x5f\x70\157\163\x74\164\x79\160\145"] : 0; goto hzOrg; faWS8: $use_publish_end_at = $posttype_config["\x75\163\x65\x5f\160\165\142\x6c\x69\x73\150\x5f\145\156\x64\137\141\x74\x5f\146\154\x67"]; goto r_lCF; jk0Es: $page_main = $PageNum->getMain("\160\x6f\163\x74"); goto tyMWY; MZPeE: $editable_flg = 1; goto EqSeC; s3m9m: if ($child_flg) { $delete_msg = TXT_POST_MSG_DELETEPOSTCHILD; } else { if ($version != $current_version) { if (count($post_pages) > 1) { $delete_msg = TXT_POST_MSG_DELETEPOSTPRIVATEALL; } else { $delete_msg = TXT_POST_MSG_DELETEPOSTPRIVATE; } } else { if (count($post_pages) > 1 && count($versions_all) == 1) { $delete_msg = TXT_POST_MSG_DELETEPOSTCHILDLEN; } if (count($post_pages) == 1 && count($versions_all) > 1) { $delete_msg = TXT_POST_MSG_DELETEPOSTCURRENT; } if (count($post_pages) > 1 && count($versions_all) > 1) { $delete_msg = TXT_POST_MSG_DELETEPOSTRELATEDALL; } } } goto kDhph; VoRee: $hash_id = !empty($post_base["\x68\x61\163\x68\x5f\x69\x64"]) ? $post_base["\x68\141\163\150\x5f\x69\x64"] : null; goto DNmyp; IBjst: $created_atby = !empty($post_base["\143\x72\145\x61\x74\x65\144\137\141\x74"]) ? date("\131\x2d\155\x2d\x64\x20\110\72\x69", strtotime($post_base["\143\162\145\141\x74\145\144\137\141\x74"])) : null; goto RMoxE; zKs_a: $delete_msg = TXT_POST_MSG_DELETEPOSTNORMAL; goto s3m9m; G4fxS: $use_wisiwyg_flg = $posttype_config["\x75\x73\145\137\167\x69\x73\x69\167\x79\x67\x5f\x66\x6c\x67"]; goto kbjGa; Y5yEa: $page_title_main .= $_SESSION[$session_key]["\x63\157\x6d\155\157\156"]["\x70\157\163\164\x74\x79\x70\x65\x73"][$_SESSION[$session_key]["\x63\157\155\155\157\x6e"]["\164\150\151\x73\x5f\160\157\163\164\164\171\160\145"]]["\156\x61\x6d\x65"]; goto znrkK; rX0FC: $access_user_role = $_SESSION[$session_key]["\x75\x73\x65\162"]["\x72\x6f\x6c\145"]; goto CFcrJ; g6Tod: $formated_categories = array(); goto NpE8V; QWeqg: $i_page = 1; goto M0vv9; LJ_No: $resource_url = !empty($posttype_config["\x72\145\163\x6f\x75\162\143\145\137\165\x72\154"]) ? $posttype_config["\162\x65\x73\x6f\x75\162\143\x65\137\165\x72\154"] : null; goto HDPGG; vcV6x: $posttype_config = $_SESSION[$session_key]["\x63\x6f\155\155\x6f\156"]["\x70\157\163\x74\x74\171\x70\145\x73"][$_SESSION[$session_key]["\x63\157\155\155\x6f\156"]["\164\150\151\163\137\160\157\163\164\164\x79\x70\145"]]; goto k3PNS; Bc2DC: $newer_version = 0; goto nMVnP; iQ2vh: $this_posttype_order = isset($_GET["\164\x68\x69\x73\137\x70\x6f\163\164\x74\171\160\x65\137\157\x72\144\x65\162"]) ? $_GET["\164\150\x69\163\x5f\x70\x6f\163\x74\x74\171\x70\x65\x5f\x6f\x72\144\145\x72"] : 0; goto FzmeR; fgyTx: $submit_label = $current_flg == 1 ? $process == 12 && $status == 1 ? TXT_POST_BTN_UPDATE : TXT_POST_BTN_PUBLISH : TXT_POST_BTN_VERSIONPUBLISH; goto jmEM1; UTYwj: $post_user_id = 0; goto C24fQ; Q7ujq: $label_content = !empty($posttype_config["\154\x61\142\x65\154\137\x63\157\156\164\x65\156\x74"]) ? $posttype_config["\154\x61\142\x65\x6c\x5f\x63\157\x6e\164\x65\156\164"] : TXT_POST_LBL_CONTENT; goto uJOUF; DOg1g: $current_version = 0; goto qrWBR; rzthG: $last_version = 0; goto DOg1g; rItJ6: if (!empty($post_base["\x63\x72\x65\141\164\145\144\x5f\142\x79"])) { try { $sql = "\12\x9\11\x9\11\x53\105\x4c\x45\103\124\40\165\x73\x2e\x6e\x69\143\153\x6e\x61\155\x65\40\101\x53\40\156\151\143\153\156\141\155\145\54\40\x75\163\56\162\157\154\145\x20\101\x53\40\x72\157\x6c\145\54\x20\x67\x72\56\x6e\x61\155\145\40\x41\x53\x20\x67\162\157\165\x70\137\x6e\x61\155\145\xa\x9\11\x9\11\x46\x52\117\115\40{$table_prefix}\165\x73\x65\x72\x73\40\101\x53\x20\165\163\x20\12\x9\x9\x9\x9\x9\114\105\106\x54\x20\x4f\x55\x54\105\122\40\x4a\117\x49\116\x20{$table_prefix}\x67\162\157\165\x70\163\x20\x41\123\x20\147\162\xa\x9\x9\x9\11\11\11\x4f\116\x20\165\x73\x2e\x67\x72\157\x75\x70\137\151\144\x20\75\40\147\x72\x2e\151\144\xa\x9\11\11\x9\x57\x48\105\x52\105\x20\165\163\56\x69\x64\x20\x3d\x20{$post_base["\143\162\145\141\164\x65\x64\137\x62\171"]}\xa\11\11"; $read_user = $pdo->prepare($sql); $read_user->execute(); $user = $read_user->fetch(PDO::FETCH_ASSOC); unset($read_user); } catch (PDOException $e) { $read_error = 5; header("\x4c\157\143\x61\x74\x69\157\156\72\x20\x2e\x2f\x65\162\162\157\x72\x2e\x70\150\x70\x3f\x70\x61\x67\145\75{$page}\x26\x72\x65\141\144\x5f\145\162\x72\x6f\x72\75{$read_error}"); die; } if (!empty($user["\147\162\157\x75\x70\x5f\x6e\141\x6d\145"])) { $created_atby .= "\xa" . $user["\147\x72\157\x75\x70\137\x6e\141\x6d\x65"]; } if (!empty($user["\x6e\151\143\x6b\x6e\x61\155\145"])) { $created_atby .= "\40" . $user["\156\x69\143\x6b\x6e\141\x6d\x65"]; } $post_user_id = $post_base["\x63\x72\x65\x61\x74\145\144\137\142\x79"]; $post_user_role = $user["\162\157\x6c\x65"]; } goto CbYdk; OoBkN: $version = !empty($post_base["\166\145\x72\163\x69\157\156"]) ? $post_base["\x76\x65\x72\163\x69\157\x6e"] : 1; goto u7SOa; nRsKO: if (!empty($child_process) && $child_process == 19) { $process_msg = TXT_POST_MSG_CHILDDELETE; $process_msg_style = "\144\x61\x6e\x67\x65\x72"; $process_msg_type = "\104\157\156\145"; } goto btw1N; crrIM: $status_text = TXT_POST_STATUSTEXT($status, $label_status, $current_flg); goto WVCZw; Huqs5: $target_id = 0; goto h4T1w; OAfRj: $permalink_slug = $slug ? $slug : $text[$language_id]["\x74\x69\x74\x6c\145"]; goto kzG6F; uJOUF: $customitem_position = $posttype_config["\143\x75\163\164\157\155\151\164\145\x6d\137\160\x6f\x73\x69\164\x69\x6f\156"]; goto bp5e2; znrkK: $page_title_sub = isset($_GET["\160\162\x6f\143\145\x73\x73"]) && $_GET["\x70\162\x6f\143\145\163\163"] == 11 ? TXT_POST_LBL_NEW : TXT_POST_LBL_EDIT; goto chjZs; xwxBU: $categories_id = !empty($post_base["\143\x61\x74\145\x67\157\x72\171\x5f\x69\144"]) ? explode("\54", $post_base["\143\x61\x74\145\x67\157\162\171\137\151\144"]) : array(); goto ifDAv; zBwpa: $label_title = !empty($posttype_config["\154\141\142\x65\x6c\137\x74\151\164\154\145"]) ? $posttype_config["\154\x61\x62\x65\x6c\x5f\x74\151\164\154\145"] : TXT_POST_LBL_TITLE; goto k0c2T; H3Sjs: $submit_value = $current_flg == 1 ? $process == 12 && $status == 1 ? "\165\160\144\x61\164\145" : "\x70\165\142\x6c\x69\x73\x68" : "\160\165\x62\x6c\x69\x73\150\x5f\166\x65\x72\x73\151\x6f\x6e"; goto fgyTx; Px46I: $posttype_slug = $_SESSION[$session_key]["\x63\x6f\x6d\x6d\157\x6e"]["\160\x6f\163\164\x74\x79\160\145\x73"][$_SESSION[$session_key]["\143\157\x6d\x6d\x6f\156"]["\164\150\x69\163\x5f\160\157\x73\x74\164\171\160\145"]]["\x73\x6c\x75\147"]; goto iQ2vh; j8fkX: foreach ($categories_id as $key => $value) { $categories[intval($value)] = intval($value); } goto Ad1DF; PZHG7: if ($status == 1 && $publish_datetime && strtotime($publish_datetime) > time()) { $label_status = "\151\x6e\146\157"; } goto FFmba; tkuKv: $permalink_uri = !empty($post_base["\x70\x65\162\155\x61\x6c\x69\156\153\137\x75\162\151"]) ? $post_base["\160\145\x72\155\141\154\x69\156\x6b\x5f\x75\x72\151"] : null; goto OoBkN; C24fQ: $post_user_role = 0; goto Eyi3h; aobkH: $status = !empty($post_base["\x73\x74\141\x74\x75\x73"]) ? $post_base["\x73\164\141\x74\165\x73"] : null; goto h0GHu; klNpS: $publish_end_at = !empty($post_base["\x70\x75\142\154\151\x73\150\137\x65\156\x64\137\141\164"]) ? date("\131\x2d\155\55\144\x20\x48\x3a\151", strtotime($post_base["\160\x75\142\x6c\x69\163\150\x5f\x65\156\144\137\x61\164"])) : null; goto mcEPt; nC5q1: $version = isset($_GET["\166\145\162\163\x69\157\156"]) ? $_GET["\x76\145\x72\163\151\157\x6e"] : 0; goto StcSK; HDPGG: $rewrite_url = !empty($posttype_config["\x72\145\167\x72\151\164\x65\x5f\165\x72\x6c"]) ? $posttype_config["\162\145\x77\x72\x69\164\145\x5f\165\162\x6c"] : null; goto zBwpa; EqSeC: if ($process == 12) { if ($edit_controll == 1) { if ($access_user_role != 1 && $post_user_id != $access_user_id) { $editable_flg = 0; } } if ($edit_controll == 2) { if ($post_user_id != $access_user_id && $access_user_role > $post_user_role) { $editable_flg = 0; } } } goto vcV6x; btw1N: if (!empty($version_process) && $version_process == 19) { $process_msg = TXT_POST_MSG_VERSIONDELETE; $process_msg_style = "\144\141\x6e\147\x65\x72"; $process_msg_type = "\104\157\x6e\x65"; } goto iu_pK; WVCZw: if (empty($categories_id) && !empty($_SESSION[$session_key]["\x63\x6f\155\x6d\x6f\156"]["\x63\141\x74\x65\x67\x6f\x72\151\145\x73"]) && !empty($_SESSION[$session_key]["\x70\x6f\x73\164\x73"]["\163\143\x5f\x63\x61\x74\145\x67\x6f\x72\171\137\151\x64"])) { array_push($categories_id, $_SESSION[$session_key]["\160\157\163\164\x73"]["\x73\143\137\143\x61\x74\145\x67\x6f\x72\x79\137\x69\x64"]); } goto rhE_c; mpevV: $edit_controll = $_SESSION[$session_key]["\143\157\156\x66\151\147\163"]["\x65\144\x69\x74\137\143\157\x6e\164\162\x6f\154\154"]; goto hpokp; ySYoe: $slug = !empty($post_base["\163\154\165\147"]) ? $post_base["\x73\x6c\165\147"] : null; goto e18D7; MXfcX: if (!empty($target_id)) { try { $post_base = array(); $sql = "\123\105\x4c\105\x43\124\x20\52\40\106\122\x4f\x4d\40{$table_prefix}\x70\x6f\163\x74\x73\137\x62\x61\x73\145\x20\x57\110\x45\x52\x45\40\x69\x64\x20\x3d\40{$target_id}\x20\101\116\x44\40\166\x65\162\x73\151\157\156\x20\x3d\x20{$version}"; $read_post_base = $pdo->prepare($sql); $read_post_base->execute(); $post_base = $read_post_base->fetch(PDO::FETCH_ASSOC); unset($read_post_base); $posts_text = array(); $sql = "\x53\x45\114\x45\x43\124\x20\52\40\106\x52\117\x4d\x20{$table_prefix}\160\x6f\x73\x74\x73\137\164\145\x78\164\x20\127\110\105\x52\105\40\142\x61\x73\x65\137\x69\144\x20\75\40{$target_id}\x20\101\x4e\x44\x20\x62\x61\163\145\137\x76\145\162\163\x69\x6f\156\40\x3d\40{$version}\x20"; $read_posts_text = $pdo->prepare($sql); $read_posts_text->execute(); while ($post_text = $read_posts_text->fetch(PDO::FETCH_ASSOC)) { $posts_text[$post_text["\x6c\141\156\x67\165\x61\147\145\x5f\x69\144"]] = $post_text; } unset($read_posts_text); if (!$create_child_flg) { $posts_custom = array(); $sql = "\12\x9\11\11\11\x9\123\105\114\105\103\124\xa\x9\11\11\x9\11\x9\x70\x63\x2e\x6c\141\156\147\x75\x61\x67\x65\x5f\x69\144\40\101\123\40\154\x61\156\x67\165\141\x67\x65\137\x69\144\54\xa\11\11\11\x9\x9\11\x70\143\x2e\143\165\x73\x74\157\x6d\x5f\x69\164\145\155\137\x69\x64\x20\101\123\40\x63\165\163\164\x6f\155\x5f\x69\x74\145\x6d\x5f\x69\144\54\xa\x9\11\11\x9\11\11\x63\x69\x2e\x74\171\x70\145\x20\101\123\40\x74\x79\160\x65\54\xa\x9\x9\x9\x9\11\x9\x70\x63\56\166\x61\154\165\145\40\x41\x53\x20\166\x61\154\165\145\xa\11\11\x9\x9\x9\x46\x52\x4f\115\x20{$table_prefix}\x70\x6f\x73\x74\x73\x5f\143\165\163\x74\x6f\x6d\40\101\x53\40\160\x63\xa\x9\11\11\x9\11\11\x49\116\x4e\x45\122\40\112\117\x49\x4e\x20{$table_prefix}\x63\x75\x73\x74\x6f\155\x5f\151\x74\x65\155\163\40\101\x53\40\x63\x69\xa\11\11\x9\11\x9\x9\x9\x4f\116\x20\x20\x70\143\56\x63\x75\163\164\x6f\x6d\137\151\x74\x65\155\x5f\x69\144\x20\x3d\40\x63\151\x2e\151\x64\12\x9\x9\x9\x9\11\127\110\105\122\x45\xa\11\11\x9\11\11\x9\x63\x69\x2e\x73\x74\x61\x74\165\163\x20\75\x20\x31\12\x9\11\x9\x9\x9\x9\x41\116\x44\40\x63\151\56\x64\x65\154\x65\x74\145\x5f\146\154\147\40\75\x20\x30\12\11\11\x9\x9\11\x9\101\116\104\x20\160\x63\x2e\x62\x61\163\145\137\x69\x64\x20\x3d\x20{$target_id}\12\11\x9\11\11\x9\x9\101\116\x44\x20\160\143\x2e\142\x61\x73\x65\137\x76\145\x72\163\x69\x6f\x6e\40\x3d\40{$version}\xa\11\11\x9"; $read_posts_custom = $pdo->prepare($sql); $read_posts_custom->execute(); while ($post_custom = $read_posts_custom->fetch(PDO::FETCH_ASSOC)) { if ($post_custom["\164\x79\x70\145"] == "\143\150\x65\x63\153\x62\x6f\x78") { $post_custom["\166\141\x6c\165\x65"] = $post_custom["\x76\141\154\165\145"] ? explode("\x2c", $post_custom["\x76\141\x6c\165\x65"]) : array(); } if ($post_custom["\x74\x79\160\145"] == "\x67\141\x6c\x6c\145\x72\171") { $prepared_data = $str = str_replace(array("\15\xa", "\15", "\12"), "\xa", $post_custom["\166\141\x6c\x75\x65"]); $separated_data = explode("\xa", $prepared_data); $urls_arr = !empty($separated_data[0]) ? explode("\x2c", $separated_data[0]) : array(); $captions_arr = !empty($separated_data[1]) ? explode("\54", $separated_data[1]) : array(); $post_custom["\x76\141\154\x75\145"] = array(); foreach ($urls_arr as $key => $value) { $post_custom["\166\141\154\165\x65"][$key]["\x75\162\154"] = $value; $post_custom["\x76\x61\154\x75\x65"][$key]["\143\x61\x70\164\151\x6f\x6e"] = !empty($captions_arr[$key]) ? $captions_arr[$key] : null; } } $posts_custom[$post_custom["\143\x75\x73\164\157\x6d\x5f\x69\x74\x65\155\137\x69\x64"]][$post_custom["\154\x61\156\147\165\x61\x67\145\x5f\151\x64"]] = $post_custom["\166\x61\154\x75\145"]; } unset($read_posts_custom); } $comments = array(); if (!empty($comment_type)) { foreach (explode("\x2c", $comment_type) as $type) { $comments[$type]["\156\x61\x6d\145"] = $posttype_comment_type[$type]; $comments[$type]["\x63\x6f\x75\x6e\164"] = $type == 1 ? array("\x61\156\x63\145\x73\x74\x65\x72" => 0, "\144\x65\163\143\145\156\x64\x61\x6e\164\163" => 0) : 0; $comments[$type]["\163\x63\x6f\x72\145\137\141\x76\x65\x72\141\x67\145"] = 0; } $sql = "\xa\x9\x9\11\11\x9\123\x45\x4c\x45\103\124\xa\11\x9\x9\11\x9\x9\164\x79\160\x65\x2c\xa\11\x9\11\x9\11\x9\x43\x41\123\x45\x20\127\110\x45\x4e\40\143\x6f\x6d\155\145\x6e\164\137\151\x64\40\x3d\40\x30\x20\x54\x48\105\116\40\x27\x61\x6e\143\145\163\x74\x65\162\x27\40\x45\114\123\x45\x20\47\144\x65\163\143\145\x6e\144\141\156\164\163\x27\x20\105\x4e\104\40\x41\x53\x20\141\164\x74\162\151\x62\x75\164\145\x2c\xa\x9\11\x9\11\11\11\x43\x4f\125\x4e\124\50\x2a\x29\40\101\x53\x20\x63\x6f\x75\156\164\137\143\x6f\155\155\145\x6e\x74\54\xa\11\x9\11\x9\11\x9\x41\x56\107\50\x73\x63\x6f\x72\145\x29\40\101\x53\40\163\143\x6f\x72\145\x5f\x61\166\145\x72\x61\x67\x65\xa\x9\11\11\x9\11\106\122\117\115\40{$table_prefix}\143\x6f\x6d\155\145\x6e\164\163\12\x9\x9\11\x9\x9\x57\x48\x45\x52\x45\xa\11\x9\11\x9\x9\11\x64\x65\x6c\x65\x74\x65\137\x66\x6c\147\x20\x3d\x20\x30\12\x9\x9\x9\11\11\11\101\x4e\104\40\160\157\163\164\137\151\x64\40\x3d\x20{$target_id}\12\x9\11\11\11\x9\x9\x41\116\104\x20\164\x79\160\145\40\111\116\x28{$comment_type}\x29\xa\11\x9\x9\x9\x9\107\122\117\125\120\x20\102\131\40\164\171\x70\145\54\x20\141\164\x74\x72\x69\142\x75\164\x65\12\11\11\x9"; $read_comment = $pdo->prepare($sql); $read_comment->execute(); while ($comment = $read_comment->fetch(PDO::FETCH_ASSOC)) { if ($comment["\x74\x79\160\145"] == 1) { if ($comment["\x61\164\164\x72\151\142\x75\164\x65"] == "\x61\156\143\x65\x73\x74\x65\x72") { $comments[1]["\143\x6f\x75\x6e\164"]["\141\156\x63\145\163\x74\x65\x72"] = $comment["\143\x6f\165\x6e\x74\137\143\157\x6d\155\145\156\x74"]; } if ($comment["\x61\164\164\x72\x69\x62\x75\164\145"] == "\144\x65\163\x63\145\x6e\x64\x61\156\164\x73") { $comments[1]["\x63\157\x75\x6e\164"]["\144\x65\163\x63\x65\x6e\144\x61\x6e\x74\163"] = $comment["\x63\157\x75\156\x74\137\143\x6f\155\155\x65\156\x74"]; } } if ($comment["\x74\171\x70\x65"] == 2) { $comments[2]["\143\157\x75\156\164"] = $comment["\x63\157\x75\156\x74\x5f\x63\x6f\x6d\155\x65\x6e\x74"]; $comments[2]["\x73\x63\x6f\x72\x65\137\141\x76\x65\x72\141\x67\145"] = $comment["\x73\x63\x6f\162\x65\137\x61\x76\145\162\x61\147\x65"]; } if ($comment["\x74\x79\x70\145"] == 3) { $comments[3]["\x63\x6f\165\x6e\164"] = $comment["\x63\x6f\x75\x6e\164\x5f\x63\157\155\155\145\x6e\x74"]; } } unset($read_comment); } } catch (PDOException $e) { $read_error = 3; header("\x4c\x6f\x63\141\164\151\x6f\156\x3a\x20\56\57\145\x72\162\157\x72\56\x70\x68\x70\x3f\x70\141\147\x65\x3d{$page}\46\x72\145\141\x64\137\x65\x72\x72\157\162\x3d{$read_error}"); die; } } goto j945x; qrWBR: try { $sql = "\12\11\11\11\x53\x45\114\x45\103\124\x20\166\145\x72\x73\151\x6f\x6e\x2c\x20\x76\145\162\163\x69\x6f\x6e\145\x64\137\141\164\54\40\x63\165\162\x72\x65\x6e\164\137\x66\x6c\x67\x2c\x20\163\x74\x61\164\165\163\12\11\11\x9\x46\x52\117\x4d\40{$table_prefix}\160\x6f\163\x74\x73\x5f\x62\x61\x73\145\12\x9\x9\11\x57\110\105\x52\105\xa\11\x9\11\11\x64\x65\x6c\145\x74\145\x5f\146\154\x67\x20\x3d\40\x30\xa\11\x9\11\11\101\116\104\40\151\144\x20\x3d\x20{$id}\xa\x9\x9\11\117\122\104\x45\x52\x20\102\131\40\x76\x65\x72\163\x69\157\x6e\x20\101\x53\x43\xa\11"; $read_versions = $pdo->prepare($sql); $read_versions->execute(); while ($record = $read_versions->fetch(PDO::FETCH_ASSOC)) { $record["\154\141\x62\145\154"] = "\x56" . $record["\x76\x65\x72\x73\x69\157\156"] . "\40\50" . substr(str_replace("\40", "\x2d", str_replace(array("\55", "\x3a"), '', $record["\166\145\162\x73\x69\157\156\x65\x64\137\141\x74"])), 0, 13) . "\51"; $versions_all[] = $record; if ($record["\143\x75\x72\162\145\156\164\137\146\154\147"]) { $current_version = $record["\x76\145\162\x73\x69\x6f\x6e"]; if (!$version) { $version = $current_version; } } } unset($read_post_pages); if (!empty($versions_all)) { $version_all_end = end($versions_all); $last_version = $version_all_end["\x76\x65\162\x73\x69\x6f\x6e"]; } } catch (PDOException $e) { $read_error = 4; header("\x4c\157\x63\x61\164\151\157\x6e\x3a\40\x2e\57\x65\x72\x72\x6f\x72\56\x70\150\160\x3f\160\141\147\145\75{$page}\46\x72\145\141\144\x5f\145\162\162\157\x72\75{$read_error}"); die; } goto Huqs5; t2Fm5: $child_flg = !empty($parent_id) ? 1 : 0; goto VoRee; A6rih: $version_process = isset($_GET["\x76\x65\x72\x73\x69\x6f\156\137\160\x72\x6f\143\145\x73\163"]) ? $_GET["\x76\145\162\x73\x69\157\156\137\x70\x72\157\143\145\163\x73"] : 0; goto HFeOY; Eyi3h: if (!$this_posttype && !empty($post_base["\x70\157\x73\164\164\171\x70\x65\x5f\151\144"])) { $this_posttype = $post_base["\160\157\x73\x74\x74\171\x70\145\x5f\x69\x64"]; } goto PZHG7; tWfI4: if ($_SESSION[$session_key]["\x75\163\x65\162"]["\162\157\x6c\145"] <= $_SESSION[$session_key]["\x63\157\x6e\146\151\x67\x73"]["\x70\165\x62\154\151\163\150\x5f\162\x6f\154\145"]) { $publish_flg = 1; } goto MZPeE; RMoxE: $updated_atby = !empty($post_base["\165\x70\144\141\x74\x65\144\137\x61\x74"]) ? date("\x59\55\x6d\x2d\144\40\x48\72\x69", strtotime($post_base["\165\160\144\x61\x74\145\x64\x5f\x61\164"])) : null; goto aobkH; MK10o: $permalink_key = !empty($posttype_config["\x70\145\x72\155\x61\154\151\156\x6b\x5f\153\145\171"]) ? $posttype_config["\x70\x65\162\x6d\141\154\x69\x6e\x6b\137\x6b\x65\171"] : null; goto VoDzB; sy3EH: $tinymce_css = file_exists($target_file_css) ? $target_file_css : "\x74\151\156\171\155\x63\x65\57\164\x69\156\171\x6d\143\x65\56\143\x73\163"; goto SynEM; x3g2S: if ($child_flg) { $allow_delete_msg = TXT_POST_MSG_ALLOWDELETEPAGE; } else { if ($version != $current_version) { $allow_delete_msg = TXT_POST_MSG_ALLOWDELETEVERSION; } } goto zKs_a; uLBLD: foreach ($_SESSION[$session_key]["\x63\157\155\x6d\x6f\156"]["\x6c\x61\156\147\165\x61\147\x65\163"] as $language_id => $value) { $text[$language_id]["\x74\x69\164\x6c\145"] = !empty($posts_text[$language_id]["\164\x69\164\x6c\145"]) ? $posts_text[$language_id]["\164\x69\x74\x6c\145"] : null; $text[$language_id]["\141\144\x64\x69\x74\151\157\156"] = !empty($posts_text[$language_id]["\x61\x64\x64\x69\164\151\x6f\156"]) ? $posts_text[$language_id]["\x61\x64\x64\x69\x74\x69\157\156"] : null; $text[$language_id]["\x63\x6f\x6e\x74\145\156\164"] = !empty($posts_text[$language_id]["\x63\x6f\x6e\x74\145\156\x74"]) ? $posts_text[$language_id]["\143\157\x6e\164\145\x6e\x74"] : null; } goto XiKfl; bp5e2: $target_file_init = "\x63\165\163\164\x6f\x6d\57\164\x69\x6e\171\x6d\143\x65\x2f\151\156\x69\164\x2f\x70\157\163\164\164\171\160\145\x5f" . sprintf("\45\60\x34\144", $_SESSION[$session_key]["\x63\157\155\155\157\x6e"]["\164\x68\151\163\137\x70\x6f\163\x74\164\x79\x70\x65"]) . "\137\x69\156\x69\x74\x2e\x6a\x73"; goto wfh53; Ix8t7: $use_version_flg = $_SESSION[$session_key]["\x63\157\156\x66\151\x67\x73"]["\165\163\145\137\166\x65\162\x73\x69\x6f\x6e\x5f\146\x6c\147"]; goto MpiZf; wMPk2: if ($rewrite_url) { switch ($permalink_key) { case 1: $uniformed_permalink_key = $hash_id; break; case 2: $uniformed_permalink_key = $id; break; case 3: $uniformed_permalink_key = date("\x59\x2f\155\57\x64", strtotime($permalink_date)) . "\57" . $permalink_slug; break; case 4: $uniformed_permalink_key = date("\x59\x2f\155", strtotime($permalink_date)) . "\57" . $permalink_slug; break; case 5: $uniformed_permalink_key = $slug; break; } $permalink_base = $rewrite_url; $permalink_type = 2; } goto vrE6q; hpokp: $access_user_id = $_SESSION[$session_key]["\165\163\145\x72"]["\151\x64"]; goto rX0FC; VoDzB: $permalink_style = !empty($posttype_config["\160\x65\x72\x6d\141\x6c\x69\x6e\153\x5f\x73\x74\171\154\145"]) ? $posttype_config["\x70\x65\x72\155\141\154\151\156\x6b\x5f\163\x74\171\x6c\x65"] : null; goto LJ_No; CbYdk: if (!empty($post_base["\x75\x70\x64\x61\164\145\144\x5f\142\x79"])) { try { $sql = "\12\x9\x9\11\11\x53\105\114\x45\x43\x54\x20\x75\163\56\156\151\143\x6b\156\x61\x6d\145\40\101\123\x20\156\151\x63\153\x6e\141\155\x65\x2c\x20\x75\163\56\162\x6f\154\145\x20\x41\123\40\x72\x6f\154\x65\54\40\x67\x72\56\x6e\141\x6d\x65\x20\x41\123\40\x67\162\157\165\x70\137\156\x61\155\x65\xa\11\x9\11\x9\106\122\117\115\40{$table_prefix}\x75\163\x65\162\x73\x20\x41\x53\40\x75\x73\x20\12\11\11\11\11\x9\x4c\x45\106\124\x20\117\x55\124\x45\x52\x20\x4a\117\x49\116\x20{$table_prefix}\147\x72\157\165\160\x73\40\x41\123\40\147\162\12\11\11\11\x9\11\11\117\x4e\x20\165\163\x2e\147\x72\157\x75\160\x5f\151\144\40\75\x20\x67\162\56\x69\144\12\x9\x9\11\11\127\x48\x45\122\105\x20\x75\x73\x2e\151\x64\40\75\x20{$post_base["\x75\160\144\x61\164\145\x64\x5f\142\x79"]}\xa\x9\11"; $read_user = $pdo->prepare($sql); $read_user->execute(); $user = $read_user->fetch(PDO::FETCH_ASSOC); unset($read_user); } catch (PDOException $e) { $read_error = 6; header("\x4c\x6f\x63\x61\x74\151\x6f\x6e\x3a\40\x2e\57\145\162\x72\157\162\x2e\160\x68\160\x3f\x70\x61\x67\x65\x3d{$page}\x26\162\x65\141\x64\137\145\162\162\x6f\x72\x3d{$read_error}"); die; } if (!empty($user["\147\x72\157\165\x70\x5f\156\141\155\x65"])) { $updated_atby .= "\xa" . $user["\147\162\x6f\165\160\x5f\156\x61\155\x65"]; } if (!empty($user["\156\x69\143\x6b\156\x61\155\x65"])) { $updated_atby .= "\40" . $user["\x6e\x69\143\x6b\x6e\x61\x6d\x65"]; } } goto j8fkX; Vyvgd: $use_tag_flg = $posttype_config["\165\163\145\137\x74\141\x67\137\146\154\x67"]; goto MK10o; RQypQ: $create_child_flg = $parent_id > 0 ? 1 : 0; goto uGCrI; mcEPt: $anchor = !empty($post_base["\x61\156\x63\x68\157\x72"]) ? $post_base["\x61\x6e\x63\150\x6f\x72"] : 0; goto xwxBU; aMzUq: $use_slug_flg = $posttype_config["\x75\163\x65\137\x73\x6c\x75\147\x5f\146\x6c\147"]; goto faWS8; chjZs: $page_icon = "\x66\x61\55\160\x65\x6e\x63\x69\154"; goto QVO1z; FzmeR: $comment_type = $_SESSION[$session_key]["\143\157\155\x6d\x6f\156"]["\160\x6f\163\164\164\x79\x70\145\163"][$_SESSION[$session_key]["\x63\157\x6d\x6d\x6f\x6e"]["\x74\x68\x69\163\x5f\160\157\x73\x74\x74\x79\x70\145"]]["\x63\157\x6d\x6d\145\156\x74\137\164\x79\160\145"]; goto jk0Es; QVO1z: $config_posttype = $_SESSION[$session_key]["\143\x6f\x6d\x6d\x6f\x6e"]["\160\x6f\163\x74\164\171\x70\x65\163"][$_SESSION[$session_key]["\143\157\x6d\x6d\157\156"]["\x74\x68\151\163\137\x70\157\x73\164\164\x79\x70\145"]]; goto Ix8t7; zYr4T: $page_title_main = $_SESSION[$session_key]["\143\157\156\x66\151\147\163"]["\x75\x73\x65\137\x6d\x75\x6c\164\x69\x73\151\x74\145\137\146\154\147"] ? $_SESSION[$session_key]["\143\x6f\x6d\x6d\157\x6e"]["\x73\151\164\x65\163"][$_SESSION[$session_key]["\143\x6f\155\155\x6f\156"]["\164\x68\151\x73\x5f\x73\151\x74\x65"]]["\x6e\141\x6d\145"] . "\x20" : ''; goto Y5yEa; kDhph: $eyecatch_target = "\x66\162\137\141\x64\155\151\x6e\x2f\145\171\145\143\141\164\x63\x68"; goto mpevV; StcSK: $process = isset($_GET["\x70\x72\157\143\x65\163\x73"]) ? $_GET["\x70\162\157\143\x65\163\x73"] : 0; goto nc80X; h0GHu: $label_status = $status != 2 ? $current_flg == 1 ? $status != 1 ? "\x64\145\x66\141\x75\x6c\x74" : "\160\162\x69\155\x61\162\x79" : "\x64\145\146\141\x75\154\x74" : "\x77\141\162\x6e\x69\x6e\147"; goto UTYwj; dwph1: if (!empty($child_process) && $child_process == 12) { $process_msg = TXT_POST_MSG_CHILDUPDATE; $process_msg_style = "\x73\x75\143\143\145\x73\x73"; $process_msg_type = "\x44\157\156\145"; } goto nRsKO; kzG6F: if ($resource_url) { switch ($permalink_key) { case 1: $uniformed_permalink_key = $hash_id; break; case 2: $uniformed_permalink_key = $id; break; case 3: $uniformed_permalink_key = date("\x59\55\155\55\x64", strtotime($permalink_date)) . "\55" . $permalink_slug; break; case 4: $uniformed_permalink_key = date("\131\55\x6d", strtotime($permalink_date)) . "\55" . $permalink_slug; break; case 5: $uniformed_permalink_key = $slug; break; } $preview_hash_salt = $_SESSION[$session_key]["\143\x6f\x6e\146\x69\x67\163"]["\160\162\x65\x76\151\145\167\137\x68\141\163\150\137\163\x61\154\x74"]; $time = substr((string) time(), 0, -1); $preview_link_post_key = generateHashId($time, 20, $preview_hash_salt) . generateHashId($id, 9, $preview_hash_salt) . generateHashId($version, 3, $preview_hash_salt); $preview_link = $resource_url . "\x3f\x70\157\163\x74\137\x6b\145\x79\x3d" . $preview_link_post_key; $preview_base = $resource_url; $permalink_base = $resource_url; $permalink_type = 1; } goto wMPk2; vrE6q: $published_version = 0; goto Bc2DC; DNmyp: $permalink_key = !empty($post_base["\x70\x65\x72\x6d\141\154\151\156\x6b\x5f\153\x65\x79"]) ? $post_base["\x70\145\162\x6d\x61\x6c\x69\156\x6b\137\153\x65\171"] : null; goto tkuKv; tyMWY: $page_sub = isset($_GET["\160\162\157\143\145\163\163"]) && $_GET["\160\x72\x6f\143\145\x73\x73"] == 11 ? $PageNum->getSubPost("\x70\x6f\x73\x74") : $PageNum->getSubPost("\160\157\163\x74\163"); goto zYr4T; nMVnP: foreach ($versions_all as $row) { if ($row["\166\145\x72\x73\151\157\156"] > $version && $row["\143\165\162\162\x65\x6e\x74\x5f\x66\154\147"] == 0 && $row["\x73\164\141\164\x75\x73"] == 2) { $newer_version = $row["\x76\145\x72\163\151\157\x6e"]; break; } }