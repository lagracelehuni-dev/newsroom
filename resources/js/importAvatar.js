import ImportImage from './class/ImportImage.js';

(function() {
    const avatarExtraClass = "avatar__import";
    const avatarInput = '.avatar-import__input';
    const avatarPreview = '.avatar-import__preview';
    const avatarBrowseBtn = '.avatar-import__browse';

    let avatarImport = new ImportImage(
        avatarExtraClass,
        avatarInput,
        avatarPreview,
        avatarBrowseBtn
    );

    // Initialize the avatar import functionality
    avatarImport.init();
})();
