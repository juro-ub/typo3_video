function setAsWatched(uid) {
    require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
        new AjaxRequest(TYPO3.settings.ajaxUrls.comment_controller_set_watched)
            .withQueryArguments({uid: uid})
            .post({
                uid: uid
            })
            .then(async function (response) {
                const resolved = await response.resolve();
                console.log(resolved);
            });
    });
}


