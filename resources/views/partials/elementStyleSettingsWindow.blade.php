<div id='elementStyleSettingsWindow' class="elementStyleSettingsWindow window">

    child grid xdddddd
    <hr>
    <h1>Layout</h1>

    <h2>Display:</h2>
    <div class="admin-tabsmenu-row-buttons" id="layout-options-buttons">
        <button class="admin-tab-button" id="block-button" value="block">
            Block
        </button>
        <button class="admin-tab-button" id="flex-button" value="flex">
            Flex
        </button>
        <button class="admin-tab-button" id="grid-button" value="grid">
            Grid
        </button>
        <button class="admin-tab-button" id="none-button" value="none">
            None
        </button>
    </div>

    
    <div class="admin-tabs-content" id="layout-tabs-content">
        <div class="admin-tab-content" id="block-tab">
        </div>

        <div class="admin-tab-content" id="flex-tab">

            <div style="display: flex; flex-direction: row;">
                <h2>Direction:</h2>
                <select id="flex-direction">
                    <option value="column">column</option>
                    <option value="row">row</option>
                    <option value="column-reverse">column-reverse</option>
                    <option value="row-reverse">row-reverse</option>
                </select>
            </div>

            <div style="display: flex; flex-direction: row;">
                <h2>Align:</h2>
                <div style="display: flex; flex-direction: column;">
                    <div class="admin-tabs-content" id="flex-direction-tabs-content">
                        <div class="admin-tab-content" id="column-tab">
                            <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px;">
                                <h2>Y (justify-content – vertical):</h2>
                                <select id="column-y">
                                    <option value="flex-start">top (flex-start)</option>
                                    <option value="center">center</option>
                                    <option value="flex-end">bottom (flex-end)</option>
                                    <option value="space-between">space-between</option>
                                    <option value="space-around">space-around</option>
                                    <option value="space-evenly">space-evenly</option>
                                </select>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px;">
                                <h2>X (align-items – horizontal):</h2>
                                <select id="column-x">
                                    <option value="flex-start">left (flex-start)</option>
                                    <option value="center">center</option>
                                    <option value="flex-end">right (flex-end)</option>
                                    <option value="stretch">stretch</option>
                                    <option value="baseline">baseline</option>
                                    <option value="start">start</option>
                                    <option value="end">end</option>
                                    <option value="self-start">self-start</option>
                                    <option value="self-end">self-end</option>
                                </select>
                            </div>
                            <div style="display: flex; flex-direction: column;">
                                <h2>gap:</h2>
                                <h3>columns:<h3/>
                                <input type="text" id="column-gap-columns" value="0px" placeholder="0px">
                                <h3>rows:<h3/>
                                <input type="text" id="column-gap-rows" value="0px" placeholder="0px">
                            </div>
                        </div>

                        <div class="admin-tab-content" id="row-tab">
                            <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px;">
                                <h2>X (justify-content – horizontal):</h2>
                                <select id="row-x">
                                    <option value="flex-start">left (flex-start)</option>
                                    <option value="center">center</option>
                                    <option value="flex-end">right (flex-end)</option>
                                    <option value="space-between">space-between</option>
                                    <option value="space-around">space-around</option>
                                    <option value="space-evenly">space-evenly</option>
                                </select>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px;">
                                <h2>Y (align-items – vertical):</h2>
                                <select id="row-y">
                                    <option value="flex-start">top (flex-start)</option>
                                    <option value="center">center</option>
                                    <option value="flex-end">bottom (flex-end)</option>
                                    <option value="stretch">stretch</option>
                                    <option value="baseline">baseline</option>
                                    <option value="start">start</option>
                                    <option value="end">end</option>
                                    <option value="self-start">self-start</option>
                                    <option value="self-end">self-end</option>
                                </select>
                            </div>
                            <div style="display: flex; flex-direction: column;">
                                <h2>gap:</h2>
                                <h3>columns:<h3/>
                                <input type="text" id="row-gap-columns" value="0px" placeholder="0px">
                                <h3>rows:<h3/>
                                <input type="text" id="row-gap-rows" value="0px" placeholder="0px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-tab-content" id="grid-tab">
            <div style="display: flex; flex-direction: column; width: 100%; max-width: 100%;">
                <h2>grid:</h2>
                <h3>columns:<h3/>
                <input type="number" value="1" placeholder="1" min="1" style="width: 30%;" id="columnsInput">
                <h3>rows:<h3/>
                <input type="number" value="1" placeholder="1" min="1" style="width: 30%;" id="rowsInput">
            </div>
            <div style="display: flex; flex-direction: column;">
                <h2>Direction:</h2>
                <select id="grid-direction">
                    <option value="row">row</option>
                    <option value="column">column</option>
                </select>
            </div>
            <div style="display: flex; flex-direction: column; width: 100%; max-width: 100%;">
                <h2>Align:</h2>
                <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; padding: 8px;">
                    <h2>X (justify-items):</h2>
                    <select id="grid-x">
                        <option value="left">left</option>
                        <option value="center">center</option>
                        <option value="right">right</option>
                        <option value="stretch">stretch</option>
                        <option value="baseline">baseline</option>
                    </select>
                </div>

                <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; padding: 8px;">
                    <h2>Y (align-items):</h2>
                    <select id="grid-y">
                        <option value="top">top</option>
                        <option value="center">center</option>
                        <option value="bottom">bottom</option>
                        <option value="stretch">stretch</option>
                        <option value="baseline">baseline</option>
                    </select>
                </div>
            </div>
            <div style="display: flex; flex-direction: column;">
                <h2>gap:</h2>
                <h3>columns:<h3/>
                <input type="text" id="grid-gap-columns" value="0px" placeholder="0px">
                <h3>rows:<h3/>
                <input type="text" id="grid-gap-rows" value="0px" placeholder="0px">
            </div>
        </div>

        <div class="admin-tab-content" id="none-tab">
        </div>
    </div>

    <hr>
    <h1>Spacing</h1>
    <h3>margin-left:<h3/>
    <input type="text" id="margin-left" value="0px" placeholder="0px">
    <h3>margin-right:<h3/>
    <input type="text" id="margin-right" value="0px" placeholder="0px">
    <h3>margin-top:<h3/>
    <input type="text" id="margin-top" value="0px" placeholder="0px">
    <h3>margin-bottom:<h3/>
    <input type="text" id="margin-bottom" value="0px" placeholder="0px">
    <h3>padding-left:<h3/>
    <input type="text" id="padding-left" value="0px" placeholder="0px">
    <h3>padding-right:<h3/>
    <input type="text" id="padding-right" value="0px" placeholder="0px">
    <h3>padding-top:<h3/>
    <input type="text" id="padding-top" value="0px" placeholder="0px">
    <h3>padding-bottom:<h3/>
    <input type="text" id="padding-bottom" value="0px" placeholder="0px">

    <hr>
    <h1>Size</h1>
    <h2>width:<h2/>
    <input type="text" id="width" value="0px" placeholder="0px">
    <h2>min width:<h2/>
    <input type="text" id="min-width" value="0px" placeholder="0px">
    <h2>max width:<h2/>
    <input type="text" id="max-width" value="0px" placeholder="0px">
    <h2>height:<h2/>
    <input type="text" id="height" value="0px" placeholder="0px">
    <h2>min height:<h2/>
    <input type="text" id="min-height" value="0px" placeholder="0px">
    <h2>max height:<h2/>
    <input type="text" id="max-height" value="0px" placeholder="0px">
    <h2>overflow:<h2/>
    <h2>Overflow:<h2/>
    <select id="overflow">
        <option value="visible">visible</option>
        <option value="hidden">hidden</option>
        <option value="cut">cut</option>
        <option value="scroll">scroll</option>
        <option value="auto">auto</option>
    </select>

    <h2>Aspect Ratio:</h2>
    <select id="aspect-ratio">
        <option value="1 / 1">1:1</option>
        <option value="4 / 3">4:3</option>
        <option value="16 / 9">16:9</option>
        <option value="21 / 9">21:9</option>
        <option value="auto">auto</option>
    </select>

    <h2>Box Sizing:</h2>
    <select id="box-sizing">
        <option value="content-box">content-box</option>
        <option value="border-box">border-box</option>
    </select>

    <h2>Object Fit:</h2>
    <select id="object-fit">
        <option value="fill">fill</option>
        <option value="contain">contain</option>
        <option value="cover">cover</option>
        <option value="none">none</option>
        <option value="scale-down">scale-down</option>
    </select>


    <h2>fit position:</h2>
    <h3>Left:<h3/>
    <input type="number" id="fit-left" value="50" placeholder="50" min="0" max="100">%
    <h3>Top:<h3/>
    <input type="number" id="fit-top" value="50" placeholder="50" min="0" max="100">%

    <hr>

    <h2>Position:</h2>
    <select id="position">
        <option value="static">static</option>
        <option value="relative">relative</option>
        <option value="fixed">fixed</option>
        <option value="absolute">absolute</option>
        <option value="sticky">sticky</option>
    </select>

    <h2>left:<h2/>
    <input type="text" id="left" value="auto" placeholder="auto">
    <h2>right:<h2/>
    <input type="text" id="right" value="auto" placeholder="auto">
    <h2>top:<h2/>
    <input type="text" id="top" value="auto" placeholder="auto">
    <h2>bottom:<h2/>
    <input type="text" id="bottom" value="auto" placeholder="auto">

    <h3>z-index:<h3/>
    <input type="text" id="z-index" value="auto" placeholder="auto">

    <hr>
    <h1>Typography:<h1/>

    <h2>Font Family:</h2>
    <select id="font-family">
        <option value="Arial, sans-serif">Arial</option>
        <option value="Helvetica, sans-serif">Helvetica</option>
        <option value="Times New Roman, serif">Times New Roman</option>
        <option value="Georgia, serif">Georgia</option>
        <option value="Courier New, monospace">Courier New</option>
        <option value="Lucida Console, monospace">Lucida Console</option>
        <option value="Tahoma, sans-serif">Tahoma</option>
        <option value="Trebuchet MS, sans-serif">Trebuchet MS</option>
        <option value="Verdana, sans-serif">Verdana</option>
        <option value="Impact, fantasy">Impact</option>
        <option value="Comic Sans MS, cursive">Comic Sans MS</option>
    </select>

    <h2>Font weight:</h2>
    <select id="font-weight">
        <option value=100">100 - Thin</option>
        <option value="200">200 - Extra Light</option>
        <option value="300">300 - Light</option>
        <option value="400">400 - Normal</option>
        <option value="500">500 - Medium</option>
        <option value="600">600 - Semi Bold</option>
        <option value="700">700 - Bold</option>
        <option value="800">800 - Extra Bold</option>
        <option value="900">900 - Black</option>
    </select>


    <h3>size:<h3/>
    <input type="text" id="font-size" value="14px" placeholder="14px">

    <h3>height:<h3/>
    <input type="text" id="line-height" value="14px" placeholder="14px">

    <h3>color:<h3/>
    <input type="text" id="color" value="#333" placeholder="#333">

    <h2>Text Align:</h2>
    <select id="text-align">
        <option value="left">Left</option>
        <option value="center">Center</option>
        <option value="right">Right</option>
        <option value="justify">Justify</option>
    </select>

    <h2>Decor:</h2>

    <h2>Text Decoration:</h2>
    <select id="text-decoration">
        <option value="none">None</option>
        <option value="underline">Underline</option>
        <option value="line-through">Line-through</option>
        <option value="overline">Overline</option>
        <option value="underline line-through">Underline & Line-through</option>
    </select>

    <!-- TODO dodać opcje decor xdd nie chce mi się -->
    <hr>
    <h2>Background:</h2>
    <h2>Background type:</h2>
    <select id="bg-type">
        <option value="solidcolor">solid color</option>
        <option value="gradient">gradient</option>
        <option value="image">image</option>
    </select>
    <div class="admin-tabs-content" id="bg-type-tabs-content">
        <div class="admin-tab-content" id="solidcolor-tab">
            <input type="text" id="background-color" value="white" placeholder="white">
        </div>

        <div class="admin-tab-content" id="gradient-tab">
            <div style="display: flex; flex-direction: row; align-items: center; gap: 10px; margin-bottom: 8px;">
                <label for="gradient">gradient:</label>
                <!--<h5>example:linear-gradient(to right, #4caf50, #81c7ff)</h5>-->
                <input type="text" id="gradient" value="none" placeholder="none">
            </div>
        </div>

        <div class="admin-tab-content" id="image-tab">
            <div style="display: flex; flex-direction: row; align-items: center; gap: 10px; margin-bottom: 8px;">
                <label for="background-image-url">Image URL:</label>
                <input type="text" id="background-image-url" placeholder="https://example.com/image.jpg">
            </div>
            <div style="display: flex; flex-direction: row; align-items: center; gap: 10px; margin-bottom: 8px;">
                <label for="background-repeat">Repeat:</label>
                <select id="background-repeat">
                    <option value="no-repeat">no-repeat</option>
                    <option value="repeat">repeat</option>
                    <option value="repeat-x">repeat-x</option>
                    <option value="repeat-y">repeat-y</option>
                </select>
            </div>
            <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                <label for="background-size">Size:</label>
                <select id="background-size">
                    <option value="auto">auto</option>
                    <option value="cover">cover</option>
                    <option value="contain">contain</option>
                </select>
            </div>
        </div>
    </div>

    <h2>Clipping:</h2>
    <select id="background-clip">
        <option value="border-box">Border Box</option>
        <option value="padding-box">Padding Box</option>
        <option value="content-box">Content Box</option>
    </select>

    <hr>
    <h1>Borders:</h1>
    <h2>Raduis:</h2>
    <h3>top-left:</h3>
    <input type="text" id="border-top-left-radius" value="14px" placeholder="14px">
    <h3>bottom-left:</h3>
    <input type="text" id="border-bottom-left-radius" value="14px" placeholder="14px">
    <h3>top-right:</h3>
    <input type="text" id="border-top-right-radius" value="14px" placeholder="14px">
    <h3>bottom-right:</h3>
    <input type="text" id="border-bottom-right-radius" value="14px" placeholder="14px">
    <h2>Borders:<h2/>
    <div style="display: flex; flex-direction: row;">
        <h3>border-top:</h3>
        <select id="border-top-style">
            <option value="solid">solid</option>
            <option value="dotted">dotted</option>
            <option value="dashed">dashed</option>
            <option value="none">none</option>
        </select>
    </div>
    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
        <h3 style="margin: 0; white-space: nowrap;">border-top-width:</h3>
        <input type="text" id="border-top-width" value="14px" placeholder="14px" style="width: 40%;">
    </div>

    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
        <h3 style="margin: 0; white-space: nowrap;">border-top-color:</h3>
        <input type="text" id="border-top-color" value="black" placeholder="black" style="width: 40%;">
    </div>

    <div style="display: flex; flex-direction: row;">
        <h3>border-bottom:</h3>
        <select id="border-bottom-style">
            <option value="solid">solid</option>
            <option value="dotted">dotted</option>
            <option value="dashed">dashed</option>
            <option value="none">none</option>
        </select>
    </div>
    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
        <h3 style="margin: 0; white-space: nowrap;">border-bottom-width:</h3>
        <input type="text" id="border-bottom-width" value="14px" placeholder="14px" style="width: 40%;">
    </div>

    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
        <h3 style="margin: 0; white-space: nowrap;">border-bottom-color:</h3>
        <input type="text" id="border-bottom-color" value="black" placeholder="black" style="width: 40%;">
    </div>

    <div style="display: flex; flex-direction: row;">
        <h3>border-right:</h3>
        <select id="border-right-style">
            <option value="solid">solid</option>
            <option value="dotted">dotted</option>
            <option value="dashed">dashed</option>
            <option value="none">none</option>
        </select>
    </div>
    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
        <h3 style="margin: 0; white-space: nowrap;">border-right-width:</h3>
        <input type="text" id="border-right-width" value="14px" placeholder="14px" style="width: 40%;">
    </div>

    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
        <h3 style="margin: 0; white-space: nowrap;">border-right-color:</h3>
        <input type="text" id="border-right-color" value="black" placeholder="black" style="width: 40%;">
    </div>

    <div style="display: flex; flex-direction: row;">
        <h3>border-left:</h3>
        <select id="border-left-style">
            <option value="solid">solid</option>
            <option value="dotted">dotted</option>
            <option value="dashed">dashed</option>
            <option value="none">none</option>
        </select>
    </div>
    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
        <h3 style="margin: 0; white-space: nowrap;">border-left-width:</h3>
        <input type="text" id="border-left-width" value="14px" placeholder="14px" style="width: 40%;">
    </div>

    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
        <h3 style="margin: 0; white-space: nowrap;">border-left-color:</h3>
        <input type="text" id="border-left-color" value="black" placeholder="black" style="width: 40%;">
    </div>
    <hr>
    <h3>opacity:<h3/>
    <input type="text" value="1" placeholder="1" style="width: 30%;" id="opacity">
    TODO effects
    <hr>
    TODO custom properties


</div>

<style>
    .elementStyleSettingsWindow select{
        border: 1px solid black;
    }


    .elementStyleSettingsWindow input{
        border: 1px solid black;
    }

    .elementStyleSettingsWindow hr{
        margin: 5px;
    }


    .admin-tabsmenu-row-buttons{
        display: flex;
        flex-direction: row;
    }

    .admin-tab-button{
        background-color: grey;
        padding: 5px;
    }

    .admin-tab-button:hover{
        background-color: lightgray;
    }

    .admin-tab-button.selected{
        background-color: lightgray;
    }

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

    .admin-tabs-content{
        display: grid;
    }

    .admin-tab-content{
        grid-row: 1 / 1;
        grid-column: 1 / 1;
        display: none;
        float: left;
    }

    .admin-tab-content.visible{
        display: flex;
        flex-direction: column;
        align-items: start;
    }
</style>