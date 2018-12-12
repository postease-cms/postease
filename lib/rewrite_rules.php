<?php

function generateRewriteRule($permalink_style, $resource_uri, $rewrite_url_flg = 0, $rewrite_uri_base = null, $rewrite_operator_flg = false, $rewrite_operator = 'php')
{
	$base_text_upper =  "# BEGIN POSTEASE" . "\n" .
											"<IfModule mod_rewrite.c>" . "\n" .
											"RewriteEngine On" . "\n";
	
	$rewrite_rule_operator =  "RewriteCond %{REQUEST_FILENAME}.{$rewrite_operator} -f" . "\n" .
														"RewriteRule ^(.*)$ $1.{$rewrite_operator}" . "\n";
	
	$base_text_bottom = "</IfModule>" . "\n" .
											"# END POSTEASE";
	
	$rewrite_rules = array
	(
		'1'  => array
		(
			'0' =>  "RewriteCond %{REQUEST_URI} ^\/[a-f0-9]{12}$" . "\n" .
							"RewriteRule ([a-f0-9]{12})$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
			'1' =>  "RewriteCond %{REQUEST_URI} {$rewrite_uri_base}\/[a-f0-9]{12}$" . "\n" .
							"RewriteRule ([a-f0-9]{12})$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
		),
		'2'  => array
		(
			'0' =>  "RewriteCond %{REQUEST_URI} .+\/[a-f0-9]{12}$" . "\n" .
							"RewriteRule ([a-f0-9]{12})$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
			'1' =>  "RewriteCond %{REQUEST_URI} {$rewrite_uri_base}\/.+\/[a-f0-9]{12}$" . "\n" .
							"RewriteRule ([a-f0-9]{12})$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
		),
		'3'  => array
		(
			'0' =>  "RewriteCond %{REQUEST_URI} ^\/\d+$" . "\n" .
							"RewriteRule (\d+)$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
			'1' =>  "RewriteCond %{REQUEST_URI} {$rewrite_uri_base}\/\d+$" . "\n" .
							"RewriteRule (\d+)$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
		),
		'4'  => array
		(
			'0' =>  "RewriteCond %{REQUEST_URI} .+\/\d+$" . "\n" .
							"RewriteRule (\d+)$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
			'1' =>  "RewriteCond %{REQUEST_URI} {$rewrite_uri_base}\/.+\/\d+$" . "\n" .
							"RewriteRule (\d+)$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
		),
		'5'  => array
		(
			'0' =>  "RewriteCond %{REQUEST_URI} ^\/[^\/]+$" . "\n" .
							"RewriteRule ([^\/]+)$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
			'1' =>  "RewriteCond %{REQUEST_URI} {$rewrite_uri_base}\/[^\/]+$" . "\n" .
							"RewriteRule ([^\/]+)$ /{$resource_uri}?post_key=$1 [QSA,L]" . "\n",
		),
		'6'  => array
		(
			'0' =>  "RewriteCond %{REQUEST_URI} ^\/[^\/]+\/[^\/]+$" . "\n" .
							"RewriteRule ([^\/]+)\/([^\/]+)$ /{$resource_uri}?post_key=$1-$2 [QSA,L]" . "\n" .
							"RewriteCond %{REQUEST_URI} ^\/[^\/]+\/[^\/]+\/[^\/]+$" . "\n" .
							"RewriteRule ([^\/]+)\/([^\/]+)\/([^\/]+)$ /{$resource_uri}?post_key=$1-$2-$3 [QSA,L]" . "\n",
			'1' =>  "RewriteCond %{REQUEST_URI} {$rewrite_uri_base}\/[^\/]+\/[^\/]+$" . "\n" .
							"RewriteRule ([^\/]+)\/([^\/]+)$ /{$resource_uri}?post_key=$1-$2 [QSA,L]" . "\n" .
							"RewriteCond %{REQUEST_URI} {$rewrite_uri_base}\/[^\/]+\/[^\/]+\/[^\/]+$" . "\n" .
							"RewriteRule ([^\/]+)\/([^\/]+)\/([^\/]+)$ /{$resource_uri}?post_key=$1-$2-$3 [QSA,L]" . "\n",
		),
		'7'  => array
		(
			'0' =>  "RewriteCond %{REQUEST_URI} ^\/\d{4}\/\d{2}\/\d{2}\/[^\/]+$" . "\n" .
							"RewriteRule (\d{4})\/(\d{2})\/(\d{2})\/([^\/]+)$ /{$resource_uri}?post_key=$1-$2-$3-$4 [QSA,L]" . "\n",
			'1' =>  "RewriteCond %{REQUEST_URI} {$rewrite_uri_base}\/\d{4}\/\d{2}\/\d{2}\/[^\/]+$" . "\n" .
							"RewriteRule (\d{4})\/(\d{2})\/(\d{2})\/([^\/]+)$ /{$resource_uri}?post_key=$1-$2-$3-$4 [QSA,L]" . "\n",
		),
		'8'  => array
		(
			'0' =>  "RewriteCond %{REQUEST_URI} ^\/\d{4}\/\d{2}\/[^\/]+$" . "\n" .
							"RewriteRule (\d{4})\/(\d{2})\/([^\/]+)$ /{$resource_uri}?post_key=$1-$2-$3 [QSA,L]" . "\n",
			'1' =>  "RewriteCond %{REQUEST_URI} {$rewrite_uri_base}\/\d{4}\/\d{2}\/[^\/]+$" . "\n" .
							"RewriteRule (\d{4})\/(\d{2})\/([^\/]+)$ /{$resource_uri}?post_key=$1-$2-$3 [QSA,L]" . "\n",
		),
	);
	
	$dir_flg = ($rewrite_uri_base) ? 1 : 0;
	$rewrite_rule_text = '# nothing rule';
	
	if (! empty($permalink_style && ! empty($rewrite_url_flg)))
	{
		$rewrite_rule_text = $base_text_upper . $rewrite_rules[$permalink_style][$dir_flg] . (($rewrite_operator_flg) ? $rewrite_rule_operator : null) . $base_text_bottom;
	}
	else if ($rewrite_operator_flg)
	{
		$rewrite_rule_text = $base_text_upper . $rewrite_rule_operator . $base_text_bottom;
	}
	return $rewrite_rule_text;
}
