class ImportImage
{
    constructor(extraClass, importInput, importPreview, browseBtn ) {
        this.extraClass = extraClass;
        this.importInput = importInput;
        this.importPreview = importPreview;
        this.browseBtn = browseBtn;
    }

    init() {
        document.querySelectorAll(`.${this.extraClass}`).forEach(importBloc => {
            const fileInput = importBloc.querySelector(this.importInput);
            const imgBloc = importBloc.querySelector(this.importPreview);
            const browseBtn = importBloc.querySelector(this.browseBtn);
            const img = imgBloc ? imgBloc.querySelector('img') : null;

            // Browse button
            if (browseBtn && fileInput && !browseBtn.dataset.imageImportInit) {
                browseBtn.addEventListener('click', () => {
                    fileInput.click();
                });
                browseBtn.dataset.imageImportInit = '1';
            }

            // File change
            if (fileInput && img && imgBloc && !fileInput.dataset.imageImportInit) {
                fileInput.addEventListener('change', function () {
                    const file = this.files && this.files.length > 0 ? this.files[0] : null;
                    if (!file) return;
                    if (!file.type.startsWith('image/')) {
                        alert('Only images are allowed.');
                        this.value = '';
                        return;
                    }
                    img.src = URL.createObjectURL(file);
                });
                fileInput.dataset.imageImportInit = '1';
            }
        });
    }
}

export default ImportImage;
