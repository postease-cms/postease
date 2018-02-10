var $css_path = document.getElementById('content').getAttribute('data-tinymce_css');
var $readonly = (document.getElementById('content').getAttribute('data-editable_flg') == 1) ? false : true;
tinymce.init({
	selector:'.mce',
	language: document.getElementById('main_menu').getAttribute('data-lang'),
	theme: 'modern',
	plugins: [
	          'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	          'codesample searchreplace wordcount visualblocks visualchars code fullscreen',
	          'insertdatetime media nonbreaking save table contextmenu directionality',
	          'emoticons template paste textcolor responsivefilemanager'
	          ],
	toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor emoticons | responsivefilemanager link print media codesample code preview fullscreen',
	image_advtab: true,
	media_live_embeds: true,
	ement_format: 'html', // html or xhtml
	content_css : $css_path,
	setup : function(ed)
	{
		ed.on('change', function()
		{
			if ($auto_save_flg)
			{
				saveArticle();
			}
			$('#draft_post').removeClass('hidden');
			$('#publish_post').removeClass('hidden');
		});
	},
	readonly : $readonly,
	// file-manager description
	external_filemanager_path: "./filemanager/",
	filemanager_title: TXT_TINYMCEAUTOSAVE_FILEMANAGERTITLE,
	external_plugins: { "filemanager" : "../filemanager/plugin.min.js"},
});
