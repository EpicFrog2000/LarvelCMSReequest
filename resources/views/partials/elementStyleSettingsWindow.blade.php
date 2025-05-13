<div id='elementStyleSettingsWindow' class="elementStyleSettingsWindow window">

    child grid xdddddd
    <hr>
    <h1>Layout</h1>
    <div class="layout-settings-container">
        <div class="options-row-container">
            <h2>Display:</h2>
            <div class="options-row-buttons" id="layout-options-main-buttons">
                <button class="settings-option-button" id="block-button">
                    Block
                </button>
                <button class="settings-option-button" id="flex-button">
                    Flex
                </button>
                <button class="settings-option-button" id="grid-button">
                    Grid
                </button>
                <button class="settings-option-button" id="none-button">
                    None
                </button>
            </div>
        </div>

        <div class="layout-content-container" id="layout-options-main-tabs">
            <div class="layout-settings-content layout-content-options-block" id="block-settings">

            </div>
            <div class="layout-settings-content layout-content-options-flex" id="flex-settings">
                <div class="options-row-container">
                    <h2>Direction:</h2>
                    <div class="options-row-buttons">
                        <button class="settings-option-button">
                            col
                        </button>
                        <button class="settings-option-button">
                            row
                        </button>
                        <button class="settings-option-button">
                            lr-wd
                        </button>
                        <button class="settings-option-button">
                            Other
                        </button>
                    </div>
                </div>






            </div>
            <div class="layout-settings-content layout-content-options-grid" id="grid-settings">

            </div>
            <div class="layout-settings-content layout-content-none" id="none-settings">

            </div>
        </div>

    </div>



    <hr>
    Spacing - Margin Padding
    <hr>
    Size
    width height min max overflow sizeoptions
    <hr>
    position
    <hr>
    typography
    <hr>
    backgrounds
    <hr>
    borders
    <hr>
    effects
    <hr>
    custom properties

    ALE Z TYM ROBOTY BEDZIE OMG

</div>

<style>
    .elementStyleSettingsWindow{
        display: flex;
        flex-direction: column;
        padding: 5px;
    }

    .layout-settings-container{
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .options-row-container{
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        
    }

    .options-row-buttons{
        display: flex;
        flex-direction: row;
        gap: 5px;
    }

    .layout-content-container{
        display: grid;
    }


    .layout-settings-content{
        grid-row: 1 / 1;
        grid-column: 1 / 1;
        display: none;
        flex-direction: column;
    }

    .layout-settings-content.visible{
        display: flex;
    }

    .settings-option-button{
        background-color: grey;
        padding: 5px;
    }

    
    .settings-option-button:hover{
        background-color: lightgray;
        padding: 5px;
    }


</style>

<script>
    const layout_options_main_buttons = document.getElementById('layout-options-main-buttons').children;
    const layout_options_main_tabs = document.getElementById('layout-options-main-tabs').children;

    Array.from(layout_options_main_buttons).forEach(button => {
        button.addEventListener('click', () => {
            let chosen_tab = document.getElementById(button.id.split('-')[0] + "-settings");
            chosen_tab.classList.add('visible');
            Array.from(layout_options_main_tabs).forEach(tab => {
                if(tab != chosen_tab){
                    tab.classList.remove('visible');
                }
            });
        });
    });



</script>