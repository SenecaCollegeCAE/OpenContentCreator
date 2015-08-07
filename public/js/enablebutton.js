$('#webquestCreativeCommonYes').on("click", function() {
	$('#webquestAllowCopyNo').prop("disabled", false);
	$('#webquestAllowCopyYes').prop("disabled", false);
});

$('#webquestCreativeCommonNo').on("click", function() {
	$('#webquestAllowCopyNo').prop("disabled", true);
	$('#webquestAllowCopyYes').prop("disabled", true);
	$('#webquestAllowCopyNo').prop("checked", true);
});

$('#triviaCreativeCommonYes').on("click", function() {
	$('#triviaAllowCopyNo').prop("disabled", false);
	$('#triviaAllowCopyYes').prop("disabled", false);
});

$('#triviaCreativeCommonNo').on("click", function() {
	$('#triviaAllowCopyNo').prop("disabled", true);
	$('#triviaAllowCopyYes').prop("disabled", true);
	$('#triviaAllowCopyNo').prop("checked", true);
});