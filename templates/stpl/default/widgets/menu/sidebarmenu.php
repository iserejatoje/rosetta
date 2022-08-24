<div class="sidebar">
    <div class="sidebar-content" data-control="menu-close">
        <div class="container">
            <div class="sidebar-panel">
                <div class="sidebar-close" data-control="menu-close">
                    меню
                </div>
                <nav>
                    <ul class="sidebar-menu">
                        <? foreach($vars['menu'] as $item) { ?>
                            <li <?if($item->ID==$vars['active']){?> class="active"<?}?>><a href="<?=$item->link?>">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <circle cx="11" cy="11" r="6"></circle>
                                    </svg>
                                    <?=$item->name?>
                                </a>
                            </li>
                        <? } ?>

                        <li><a href="/reward">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <circle cx="11" cy="11" r="6"></circle>
                            </svg>
                            Наше мастерство
                        </a></li>
                    </ul>
                    <div class="sedebar-separator"></div>
                    <div class="sidebar-outer-menu">
                        <a href="http://wedding.rosetta.florist" class="btn-wedding">
                            <span class="btn-wedding__img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 211.93 46"><defs><style>.cls-1{isolation:isolate;}.cls-2{fill:#fff;}</style></defs><title>контур</title><g id="Слой_2" data-name="Слой 2"><g id="Прямоугольник_1" data-name="Прямоугольник 1" class="cls-1"><g id="Слой_1-2" data-name="Слой 1-2"><g id="_Layer_1" data-name=" Layer 1"><g id="_258996184768" data-name=" 258996184768"><path class="cls-2" d="M29.83,6.91A20.3,20.3,0,0,1,40.05,34.12a21.22,21.22,0,0,1-27.88,10A20.29,20.29,0,0,1,2,16.88a20.74,20.74,0,0,1,10.22-10,7,7,0,0,0,1.21,1.92A18.09,18.09,0,0,0,3.89,32.94a18.89,18.89,0,0,0,24.7,9.27,18.63,18.63,0,0,0,8.09-6.74,7.81,7.81,0,0,1-2.89,1.42,6.57,6.57,0,0,1-5.9-1.21c-2.44-2.14-2.65-4.31-3.89-7-.65-1.38-1.52-2.48-3.14-2.53h0v4.15c.12,2.73.53,4.35,3.31,4.58.14.39.76,1.68.83,2.09A41.61,41.61,0,0,0,9.27,37l.83-2.09c2.83,0,3.41-1.65,3.54-4.5V19.64c-.13-3-.71-3-3.49-3.22l-.51-2c6.46,2,8.77-.44,13.82-.4a13.18,13.18,0,0,1,6.24,1.31,5.56,5.56,0,0,1,3.11,5.06,4.85,4.85,0,0,1-3.74,5,12,12,0,0,1-2.92.36,8.86,8.86,0,0,1,5.2,2.93,14.25,14.25,0,0,0,2.28,2.44,3.53,3.53,0,0,0,2.49.74c1.26-.15,2.67-.74,3-1.89A18.15,18.15,0,0,0,28.61,8.83,7.9,7.9,0,0,0,29.83,6.91ZM23,24.67c2.11-.41,2.53-3,2.53-4.46,0-2-1.05-4-3.33-4a2.75,2.75,0,0,0-.85.18.65.65,0,0,0-.44.71v7.61A12.74,12.74,0,0,0,23,24.67ZM21,1.5a3.69,3.69,0,0,1,5.74-.24c1.85,1.87,1.28,4.87-.65,6.48C24.69,8.9,22.74,9.39,21,11.68c-1.74-2.29-3.7-2.78-5.12-3.94C14,6.13,13.41,3.13,15.25,1.26A3.71,3.71,0,0,1,21,1.5Z"/></g></g></g></g><g id="переход"><g id="Все_к_свадьбе" data-name="Все к свадьбе"><path class="cls-2" d="M68.17,15.79l-.09-.08v-.59l.09-.08c1.34.07,2.37.1,3.1.1.27,0,1.35,0,3.24-.1l1.33,0a7.77,7.77,0,0,1,2.51.32,2.93,2.93,0,0,1,1.48,1.11,3.1,3.1,0,0,1,.57,1.83,3.7,3.7,0,0,1-.94,2.41,5.46,5.46,0,0,1-3,1.59,13.79,13.79,0,0,1,2.09.34,4,4,0,0,1,1.42.69,3.31,3.31,0,0,1,.94,1.2,4,4,0,0,1,.35,1.71A5.26,5.26,0,0,1,81,27.77a4.68,4.68,0,0,1-.86,1.56,6.08,6.08,0,0,1-1.52,1.32,6.78,6.78,0,0,1-1.82.8,9.41,9.41,0,0,1-2.31.24c-.19,0-.75,0-1.69-.05l-1.69,0c-.53,0-1.18,0-2,.09L69,31.6v-.39l.09-.11a4,4,0,0,0,.79-.42,9,9,0,0,0,.17-2.08c0-1.3.06-2.3.06-3v-7c0-.58,0-1,0-1.41a7.08,7.08,0,0,0-.07-.78.57.57,0,0,0-.13-.33.83.83,0,0,0-.27-.16,2.68,2.68,0,0,0-.58-.11Zm4.21,6.15c.39,0,.83,0,1.33,0a5,5,0,0,0,3.37-.87,3.05,3.05,0,0,0,1-2.37,2.92,2.92,0,0,0-.36-1.5,2.37,2.37,0,0,0-1.15-.94A5.52,5.52,0,0,0,74.41,16a9.08,9.08,0,0,0-1.92.18c-.07.7-.11,1.93-.11,3.68Zm0,8.55a8.22,8.22,0,0,0,1.86.21,5.33,5.33,0,0,0,2.62-.54,3.35,3.35,0,0,0,1.4-1.49,4.83,4.83,0,0,0,.45-2.08,3.83,3.83,0,0,0-1-2.71c-.64-.67-2-1-4.13-1-.35,0-.78,0-1.27.05v4Z"/><path class="cls-2" d="M92.58,30.35l-.46.78a6.85,6.85,0,0,1-3.38.83,5.12,5.12,0,0,1-4-1.53,5.61,5.61,0,0,1-1.41-4,7.25,7.25,0,0,1,.24-2,5,5,0,0,1,.61-1.43,3.71,3.71,0,0,1,.81-.89,15.16,15.16,0,0,1,1.51-.91,11.12,11.12,0,0,1,1.6-.77,4.86,4.86,0,0,1,1.49-.18,5.73,5.73,0,0,1,3,.69c-.14.88-.26,1.87-.34,2.95l-.1.1h-.48L91.55,24a7.56,7.56,0,0,0-.13-1.32c0-.23-.36-.47-.93-.73a4.27,4.27,0,0,0-1.81-.39,3.54,3.54,0,0,0-1.71.41,2.52,2.52,0,0,0-1.13,1.32,5.81,5.81,0,0,0-.38,2.2,7.4,7.4,0,0,0,.3,2.1,5.38,5.38,0,0,0,.81,1.7,3.7,3.7,0,0,0,1.31,1.09,4.1,4.1,0,0,0,1.83.41A4.7,4.7,0,0,0,91,30.58,8.83,8.83,0,0,0,92.34,30Z"/><path class="cls-2" d="M103.42,29.88l-.37.84A6.9,6.9,0,0,1,99.17,32a6.71,6.71,0,0,1-2.67-.55,4.49,4.49,0,0,1-2-1.87,6.07,6.07,0,0,1-.79-3.16A7.31,7.31,0,0,1,94,24.18a5.18,5.18,0,0,1,.64-1.47,4.92,4.92,0,0,1,1.13-1.07,7.74,7.74,0,0,1,1.68-.94,5.34,5.34,0,0,1,1.93-.35,4.61,4.61,0,0,1,2.47.66,3.62,3.62,0,0,1,1.51,1.7,5.52,5.52,0,0,1,.43,2.19c0,.24,0,.47,0,.7l-.13.13a11.91,11.91,0,0,1-2.14.23L99.67,26H95.91a4.85,4.85,0,0,0,1.22,3.58,4.09,4.09,0,0,0,2.93,1.15,4.47,4.47,0,0,0,1.58-.29,9.33,9.33,0,0,0,1.6-.78Zm-7.51-4.79c.14,0,.68.05,1.63.08s1.63,0,2.09,0c1.08,0,1.74,0,2-.05,0-.19,0-.34,0-.44a4.16,4.16,0,0,0-.74-2.7,2.47,2.47,0,0,0-2-.88,2.62,2.62,0,0,0-2.18,1A4.75,4.75,0,0,0,95.91,25.09Z"/><path class="cls-2" d="M111.49,31.6v-.49l.09-.08a6.05,6.05,0,0,0,1.07-.16.64.64,0,0,0,.31-.3,3,3,0,0,0,.14-1.08c0-.57,0-1.34,0-2.32v-2c0-.61,0-1.29,0-2.05a3.81,3.81,0,0,0-.15-1.35.62.62,0,0,0-.32-.3,5,5,0,0,0-1-.14l-.09-.1v-.49l.09-.08q1.15.09,2.52.09c1,0,1.79,0,2.53-.09l.09.08v.49l-.09.1a5.65,5.65,0,0,0-1.07.15.6.6,0,0,0-.31.3,3.54,3.54,0,0,0-.14,1.08q0,.86,0,2.31V26h.1q1.51-1.31,2.88-2.7c.91-.92,1.42-1.44,1.51-1.55a.48.48,0,0,0,.13-.29c0-.1-.07-.16-.21-.2v-.46l.09-.09q1,.09,1.35.09a12,12,0,0,0,1.35-.09l.08.09v.49l-.08.08a3.06,3.06,0,0,0-1.31.4,49.28,49.28,0,0,0-4,3.47l4.79,5a5,5,0,0,0,.7.67A1,1,0,0,0,123,31l.06.06v.5l-.06.07a14.65,14.65,0,0,1-2.21-.16,2.38,2.38,0,0,1-.87-.51c-.31-.27-.84-.81-1.58-1.6Q116,27,115.18,26.26h-.1v.91c0,.64,0,1.33,0,2.08a4.09,4.09,0,0,0,.14,1.33.58.58,0,0,0,.33.29,6,6,0,0,0,1,.16l.09.08v.49l-.09.09c-.77-.06-1.62-.09-2.53-.09s-1.78,0-2.52.09Z"/><path class="cls-2" d="M139.31,30.35l-.47.78a6.83,6.83,0,0,1-3.38.83,5.13,5.13,0,0,1-4-1.53,5.61,5.61,0,0,1-1.41-4,7.25,7.25,0,0,1,.24-2,5.3,5.3,0,0,1,.61-1.43,3.55,3.55,0,0,1,.82-.89,14.72,14.72,0,0,1,1.5-.91,11.12,11.12,0,0,1,1.6-.77,4.91,4.91,0,0,1,1.49-.18,5.79,5.79,0,0,1,3,.69c-.15.88-.26,1.87-.34,2.95l-.11.1h-.48l-.1-.11a10.39,10.39,0,0,0-.13-1.32c-.06-.23-.37-.47-.93-.73a4.31,4.31,0,0,0-1.82-.39,3.54,3.54,0,0,0-1.71.41,2.57,2.57,0,0,0-1.13,1.32,5.81,5.81,0,0,0-.38,2.2,7.07,7.07,0,0,0,.31,2.1,5.37,5.37,0,0,0,.8,1.7,3.65,3.65,0,0,0,1.32,1.09,4,4,0,0,0,1.83.41,4.62,4.62,0,0,0,1.23-.17,8.48,8.48,0,0,0,1.39-.54Z"/><path class="cls-2" d="M140.5,31.6v-.49l.1-.08a5.87,5.87,0,0,0,1.06-.16.6.6,0,0,0,.31-.3,3.14,3.14,0,0,0,.15-1.08c0-.57,0-1.34,0-2.32v-2c0-.61,0-1.29,0-2.05a4.4,4.4,0,0,0-.15-1.35.67.67,0,0,0-.33-.3,4.73,4.73,0,0,0-1-.14l-.1-.1v-.49l.1-.08q1.6.09,2.43.09l1.12,0c1.36,0,2.3-.06,2.81-.06a2.79,2.79,0,0,1,2,.6,2,2,0,0,1,.63,1.5c0,1.28-.87,2.15-2.61,2.62a3.79,3.79,0,0,1,2.39.8,2.39,2.39,0,0,1,.77,1.85,3.53,3.53,0,0,1-1.06,2.51,4.51,4.51,0,0,1-3.4,1.11l-.69,0c-.65,0-1.17,0-1.55,0l-2.82.09ZM144,25.26c.32,0,.57,0,.75,0a3.63,3.63,0,0,0,2.28-.53,1.76,1.76,0,0,0,.65-1.47,1.82,1.82,0,0,0-.52-1.35,2.51,2.51,0,0,0-1.84-.54q-.59,0-1.23.06Zm0,.7.09,4.89a8.58,8.58,0,0,0,1.29.08,2.86,2.86,0,0,0,1.62-.4,2.27,2.27,0,0,0,.86-1,3,3,0,0,0,.26-1.24,2.62,2.62,0,0,0-.35-1.36,1.86,1.86,0,0,0-1-.81,6.13,6.13,0,0,0-1.86-.22Z"/><path class="cls-2" d="M153.59,23.66l-.46-.12-.09-.12c0-.12,0-.28,0-.48V22a14.09,14.09,0,0,1,2.15-1.19,5,5,0,0,1,1.91-.36,4.16,4.16,0,0,1,2.87.95A3.3,3.3,0,0,1,161,24L161,26.3v3.5a2.06,2.06,0,0,0,.11.83.54.54,0,0,0,.29.27,4.39,4.39,0,0,0,.75.12l.1.1v.47l-.1.09c-.61-.05-1.08-.08-1.43-.08s-.83,0-1.52.08l-.18-.16.05-1.89-1.5,1.17c-.52.42-.88.69-1.06.82a3.53,3.53,0,0,1-1.4.27,3.1,3.1,0,0,1-2.2-.74,2.64,2.64,0,0,1-.8-2,3.27,3.27,0,0,1,.69-2.16,4.54,4.54,0,0,1,2.09-1.32,25.55,25.55,0,0,1,4.18-.86,6.34,6.34,0,0,0-.1-1.24,2.3,2.3,0,0,0-.48-1,2.35,2.35,0,0,0-1-.7,3.6,3.6,0,0,0-1.31-.23,4.56,4.56,0,0,0-.75.06,3.59,3.59,0,0,0-.68.21,1.61,1.61,0,0,0-.38.2.51.51,0,0,0-.13.21c0,.05-.11.23-.26.56a5.16,5.16,0,0,0-.29.72ZM159,25.47a12.06,12.06,0,0,0-3.8,1.07,2.22,2.22,0,0,0-1.1,2.06,1.87,1.87,0,0,0,.49,1.4,1.79,1.79,0,0,0,1.33.48A4.21,4.21,0,0,0,159,28.67Z"/><path class="cls-2" d="M168.66,21.24v-.49l.08-.08q1.14.09,2.58.09c.84,0,1.64,0,2.39-.09l.1.08c0,.59-.05,2.26-.05,5,0,1.13,0,2.79,0,5l.09.09a19.85,19.85,0,0,0,2.06-.11l.15.15A39.28,39.28,0,0,0,175,35.18h-.51c0-.36,0-.92,0-1.68a4.87,4.87,0,0,0-.17-1.36.82.82,0,0,0-.45-.37,4.08,4.08,0,0,0-1.39-.15H172l-3.08,0c-.59,0-1.3,0-2.12,0a10.48,10.48,0,0,0-1.46.11A.76.76,0,0,0,165,32a1.33,1.33,0,0,0-.19.61,18,18,0,0,0-.06,1.91c0,.18,0,.4,0,.65h-.51a28.75,28.75,0,0,0-1.12-4.45l.15-.16a12.91,12.91,0,0,0,1.37.16l3.87-5.4c1.33-1.86,2.05-2.88,2.14-3.07a1.1,1.1,0,0,0,.13-.42c0-.22-.18-.34-.55-.36l-1.48-.14Zm3,.8q-3.83,5.55-5.87,8.82h6.1l0-4.37c0-2.14,0-3.62-.05-4.45Z"/><path class="cls-2" d="M177.28,31.6v-.49l.09-.08a4.89,4.89,0,0,0,1-.24.8.8,0,0,0,.45-.3.87.87,0,0,0,.14-.41c0-.17,0-.59.06-1.27s0-1.21,0-1.57V25.12a14.26,14.26,0,0,0-.18-3.19c-.12-.28-.63-.48-1.54-.59l-.09-.1v-.49l.09-.08c1.09.06,2,.09,2.71.09s1.59,0,2.7-.09l.09.08v.49l-.09.1a5.17,5.17,0,0,0-1.05.22,1.32,1.32,0,0,0-.41.26.63.63,0,0,0-.15.34c0,.13,0,.55-.08,1.27s0,1.28,0,1.69v.2q1-.06,1.89-.06a7.24,7.24,0,0,1,2.32.29,2.44,2.44,0,0,1,1.27,1,3,3,0,0,1,.47,1.69,3.23,3.23,0,0,1-.58,1.92A3.27,3.27,0,0,1,185,31.34a5.73,5.73,0,0,1-2.22.35c-.24,0-.7,0-1.38,0s-1,0-1.31,0c-.73,0-1.63,0-2.71.09Zm3.77-5.73V28c0,1.17,0,1.91,0,2.24a1.1,1.1,0,0,0,.2.67,1.07,1.07,0,0,0,.75.18,2.64,2.64,0,0,0,2.12-.84,3.16,3.16,0,0,0,.72-2.15,2.67,2.67,0,0,0-.25-1.23,1.62,1.62,0,0,0-.77-.76,3.43,3.43,0,0,0-1.52-.26Z"/><path class="cls-2" d="M199,14.29l.29.32c-.37.83-.66,1.42-.87,1.79a2,2,0,0,1-.71.75,2.82,2.82,0,0,1-1.28.21l-2.64.08a7.4,7.4,0,0,0-2.12.29,2.79,2.79,0,0,0-1.18.77,3.89,3.89,0,0,0-.75,1.5,13.41,13.41,0,0,0-.3,3.09h.18A5.88,5.88,0,0,1,191.82,21a7.4,7.4,0,0,1,7.09.66,5,5,0,0,1,1.51,4,6.35,6.35,0,0,1-1.62,4.62,5.79,5.79,0,0,1-4.32,1.66,6,6,0,0,1-3.3-.79,5,5,0,0,1-1.91-2.49,12.39,12.39,0,0,1-.67-4.49,16.44,16.44,0,0,1,.37-3.62,9.28,9.28,0,0,1,1-2.72,4.19,4.19,0,0,1,3.34-2.14c.69-.07,1.68-.13,3-.16a5.35,5.35,0,0,0,1.59-.19A2.81,2.81,0,0,0,199,14.29Zm-8.18,11.57a11.24,11.24,0,0,0,.18,2.23,4.91,4.91,0,0,0,.65,1.61,3.2,3.2,0,0,0,2.85,1.55,3,3,0,0,0,2.86-1.64,8.13,8.13,0,0,0,.9-4,5.86,5.86,0,0,0-.89-3.31A3.09,3.09,0,0,0,194.58,21a3.36,3.36,0,0,0-2.78,1.29A5.61,5.61,0,0,0,190.78,25.86Z"/><path class="cls-2" d="M211.59,29.88l-.38.84a7,7,0,0,1-2.17,1,7.14,7.14,0,0,1-1.71.24,6.7,6.7,0,0,1-2.66-.55,4.44,4.44,0,0,1-2-1.87,6,6,0,0,1-.79-3.16,7.64,7.64,0,0,1,.3-2.22,5.48,5.48,0,0,1,.64-1.47,4.92,4.92,0,0,1,1.13-1.07,7.58,7.58,0,0,1,1.69-.94,5.24,5.24,0,0,1,1.92-.35A4.64,4.64,0,0,1,210,21a3.6,3.6,0,0,1,1.5,1.7,5.53,5.53,0,0,1,.44,2.19,5.37,5.37,0,0,1,0,.7l-.13.13a11.81,11.81,0,0,1-2.14.23l-1.78.06h-3.76a4.81,4.81,0,0,0,1.22,3.58,4.07,4.07,0,0,0,2.92,1.15,4.43,4.43,0,0,0,1.58-.29,9,9,0,0,0,1.6-.78Zm-7.51-4.79c.14,0,.68.05,1.62.08s1.64,0,2.09,0c1.09,0,1.75,0,2-.05,0-.19,0-.34,0-.44a4.16,4.16,0,0,0-.73-2.7,2.5,2.5,0,0,0-2-.88,2.6,2.6,0,0,0-2.17,1A4.75,4.75,0,0,0,204.08,25.09Z"/></g></g></g></svg>
                            </span>
                            <span class="btn-wedding__text">Свадебная тема</span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>