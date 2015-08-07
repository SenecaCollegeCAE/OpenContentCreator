tinymce.init({
	selector:'textarea.tinymceTextArea', //All textareas with that class name
	plugins: [ //Plugin to upload file with jbImages
	          "advlist autolink lists link image charmap print preview anchor",
	          "searchreplace visualblocks code fullscreen",
	          "insertdatetime media table contextmenu paste jbimages"
	],
	theme_advanced_resizing: false, 
	statusbar: false, 
	menubar: false,
	height: "200",
	//toolbar: "insertfile | bold italic | alignleft aligncenter alignright | bullist numlist | outdent indent | link image jbimages",
	toolbar: "insertfile | bold italic | alignleft aligncenter alignright | bullist numlist | outdent indent | link image | media",
	relative_urls: false
	//content_css: "../../../public/css/style.css" //custom css if needed
});