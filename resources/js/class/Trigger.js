class Trigger
{
    constructor (showTrigger, hiddenTrigger, blocElement)
    {
        this.showTrigger = showTrigger;
        this.hiddenTrigger = hiddenTrigger;
        this.blocElement = blocElement;
    }

    show ()
    {
        if (this.showTrigger && this.blocElement) {
            this.showTrigger.addEventListener('click', () => {
                this.blocElement.classList.add('is-visible');
            });
        }
    }

    hidden ()
    {
        if (this.hiddenTrigger && this.blocElement) {
            this.hiddenTrigger.addEventListener('click', () => {
                this.blocElement.classList.remove('is-visible');
            });
        }
    }

    toggle ()
    {
        if (this.showTrigger && this.hiddenTrigger && this.blocElement) {
            this.showTrigger.addEventListener('click', () => {
                this.blocElement.classList.add('is-visible');
            });

            this.hiddenTrigger.addEventListener('click', () => {
                this.blocElement.classList.remove('is-visible');
            });
        }
    }

}

export default Trigger;
