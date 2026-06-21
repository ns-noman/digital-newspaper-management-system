// var uni_string_conversion_map = {
//     "iÂ¨": "à¦°â€Œà§à¦¯",
//     "k^": "à¦¶à§à¦¬",
//     "nÅ¸": "à¦¹à§à¦¬",
//     "à¦¹Å¸": "à¦¹à§à¦¬",
//     "ÂªÂ¨": "à§à¦°à§à¦¯",
//     "Â°": "à¦•à§à¦•",
//     "Â±": "à¦•à§à¦Ÿ",
//     "Â³": "à¦•à§à¦¤",
//     "KÂ¡": "à¦•à§à¦¬",
//     "Â¯Å’": "à¦¸à§à¦•à§à¦°",
//     "Âµ": "à¦•à§à¦°",
//     "KÂ¬": "à¦•à§à¦²",
//     "Â¶": "à¦•à§à¦·",
//     "Ã¿": "à¦•à§à¦·",
//     "Â·": "à¦•à§à¦¸",
//     "Â¸": "à¦—à§",
//     "Â»": "à¦—à§à¦§",
//     "MÅ“": "à¦—à§à¦¨",
//     "MÂ¥": "à¦—à§à¦®",
//     "MÂ­": "à¦—à§à¦²",
//     "Â¼": "à¦™à§à¦•",
//     "â€¢Â¶": "à¦™à§à¦•à§à¦·",
//     "â€¢L": "à¦™à§à¦–",
//     "Â½": "à¦™à§à¦—",
//     "â€¢N": "à¦™à§à¦˜",
//     "â€¢": "à¦•à§à¦¸",
//     "â€P": "à¦šà§à¦š",
//     "â€Q": "à¦šà§à¦›",
//     "â€QÂ¡": "à¦šà§à¦›à§à¦¬",
//     "â€T": "à¦šà§à¦ž",
//     "Â¾Â¡": "à¦œà§à¦œà§à¦¬",
//     "Â¾": "à¦œà§à¦œ",
//     "Ã€": "à¦œà§à¦",
//     "Ã": "à¦œà§à¦ž",
//     "RÂ¡": "à¦œà§à¦¬",
//     "Ã‚": "à¦žà§à¦š",
//     "Ãƒ": "à¦žà§à¦›",
//     "Ã„": "à¦žà§à¦œ",
//     "Ã…": "à¦žà§à¦",
//     "Ã†": "à¦Ÿà§à¦Ÿ",
//     "UÂ¡": "à¦Ÿà§à¦¬",
//     "UÂ¥": "à¦Ÿà§à¦®",
//     "Ã‡": "à¦¡à§à¦¡",
//     "Ãˆ": "à¦£à§à¦Ÿ",
//     "Ã‰": "à¦£à§à¦ ",
//     "Ã": "à¦¨à§à¦¸",
//     "Ã": "à¦£à§à¦¡",
//     "Å¡â€˜": "à¦¨à§à¦¤à§",
//     "Y\\^": "à¦£à§à¦¬",
//     "Ã‹": "à¦¤à§à¦¤",
//     "Ã‹Â¡": "à¦¤à§à¦¤à§à¦¬",
//     "ÃŒ": "à¦¤à§à¦¥",
//     "ZÂ¥": "à¦¤à§à¦®",
//     "Å¡â€”Â¡": "à¦¨à§à¦¤à§à¦¬",
//     "ZÂ¡": "à¦¤à§à¦¬",
//     "ÃŽ": "à¦¤à§à¦°",
//     "_Â¡": "à¦¥à§à¦¬",
//     "ËœM": "à¦¦à§à¦—",
//     "ËœN": "à¦¦à§à¦˜",
//     "Ã": "à¦¦à§à¦¦",
//     "Ã—": "à¦¦à§à¦§",
//     "ËœÂ¡": "à¦¦à§à¦¬",
//     "Ã˜": "à¦¦à§à¦¬",
//     "â„¢Â¢": "à¦¦à§à¦­",
//     "Ã™": "à¦¦à§à¦®",
//     "`ÂªÃ¦": "à¦¦à§à¦°à§",
//     "aÅ¸": "à¦§à§à¦¬",
//     "aÂ¥": "à¦§à§à¦®",
//     "â€ºU": "à¦¨à§à¦Ÿ",
//     "Ãš": "à¦¨à§à¦ ",
//     "Ã›": "à¦¨à§à¦¡",
//     "Å¡Ã": "à¦¨à§à¦¤",
//     "Å¡â€”": "à¦¨à§à¦¤",
//     "Å¡Â¿": "à¦¨à§à¦¤à§à¦°",
//     "Å¡â€™": "à¦¨à§à¦¥",
//     "â€º`": "à¦¨à§à¦¦",
//     "â€ºÃ˜": "à¦¨à§à¦¦à§à¦¬",
//     "Ãœ": "à¦¨à§à¦§",
//     "bÅ“": "à¦¨à§à¦¨",
//     "Å¡\\^": "à¦¨à§à¦¬",
//     "bÂ¥": "à¦¨à§à¦®",
//     "Ãž": "à¦ªà§à¦Ÿ",
//     "ÃŸ": "à¦ªà§à¦¤",
//     "cÅ“": "à¦ªà§à¦¨",
//     "Ã ": "à¦ªà§à¦ª",
//     "cÃ¸": "à¦ªà§à¦²",
//     "cÂ­": "à¦ªà§à¦²",
//     "Ã¡": "à¦ªà§à¦¸",
//     "dÂ¬": "à¦«à§à¦²",
//     "Ã¢": "à¦¬à§à¦œ",
//     "Ã£": "à¦¬à§à¦¦",
//     "Ã¤": "à¦¬à§à¦§",
//     "eÅ¸": "à¦¬à§à¦¬",
//     "eÃ¸": "à¦¬à§à¦²",
//     "Ã¥": "à¦­à§à¦°",
//     "gÅ“": "à¦®à§à¦¨",
//     "Â¤Ãº": "à¦®à§à¦ª",
//     "Ã§": "à¦®à§à¦«",
//     "Â¤\\^": "à¦®à§à¦¬",
//     "Â¤Â¢": "à¦®à§à¦­",
//     "Â¤Â£": "à¦®à§à¦­à§à¦°",
//     "Â¤Â§": "à¦®à§à¦®",
//     "Â¤Â­": "à¦®à§à¦²",
//     "iâ€œ": "à¦°à§",
//     "iÃ¦": "à¦°à§",
//     "iÆ’": "à¦°à§‚",
//     "Ã©": "à¦²à§à¦•",
//     "Ãª": "à¦²à§à¦—",
//     "Ã«": "à¦²à§à¦Ÿ",
//     "Ã¬": "à¦²à§à¦¡",
//     "Ã­": "à¦²à§à¦ª",
//     "Ã®": "à¦²à§à¦«",
//     "jÂ¦": "à¦²à§à¦¬",
//     "jÂ¥": "à¦²à§à¦®",
//     "jÃ¸": "à¦²à§à¦²",
//     "Ã¯": "à¦¶à§",
//     "Ã°": "à¦¶à§à¦š",
//     "kÅ“": "à¦¶à§à¦¨",
//     "kÃ¸": "à¦¶à§à¦²",
//     "k\\^": "à¦¶à§à¦¬",
//     "kÂ¥": "à¦¶à§à¦®",
//     "kÂ­": "à¦¶à§à¦²",
//     "Â®â€¹": "à¦·à§à¦•",
//     "Â®Å’": "à¦·à§à¦•à§à¦°",
//     "Ã³": "à¦·à§à¦Ÿ",
//     "Ã´": "à¦·à§à¦ ",
//     "Ã²": "à¦·à§à¦£",
//     "Â®Ãº": "à¦·à§à¦ª",
//     "Ãµ": "à¦·à§à¦«",
//     "Â®Â§": "à¦·à§à¦®",
//     "Â¯â€¹": "à¦¸à§à¦•",
//     "Ã·": "à¦¸à§à¦Ÿ",
//     "Ã¶": "à¦¸à§à¦–",
//     "Â¯â€”": "à¦¸à§à¦¤",
//     "Â¯Ã": "à¦¸à§à¦¤",
//     "Â¯â€˜": "à¦¸à§à¦¤à§",
//     "Â¯Â¿": "à¦¸à§à¦¤à§à¦°",
//     "Â¯â€™": "à¦¸à§à¦¥",
//     "mÅ“": "à¦¸à§à¦¨",
//     "Â¯Ãº": "à¦¸à§à¦ª",
//     "Ã¹": "à¦¸à§à¦«",
//     "Â¯\\^": "à¦¸à§à¦¬",
//     "Â¯Â§": "à¦¸à§à¦®",
//     "Â¯Ã¸": "à¦¸à§à¦²",
//     "Ã»": "à¦¹à§",
//     "nÃ¨": "à¦¹à§à¦£",
//     "Ã½": "à¦¹à§à¦¨",
//     "Ã¾": "à¦¹à§à¦®",
//     "nÂ¬": "à¦¹à§à¦²",
//     "Ã¼": "à¦¹à§ƒ",
//     "Â©": "à¦°à§",
//     "Av": "à¦†",
//     "A": "à¦…",
//     "B": "à¦‡",
//     "C": "à¦ˆ",
//     "D": "à¦‰",
//     "E": "à¦Š",
//     "F": "à¦‹",
//     "G": "à¦",
//     "H": "à¦",
//     "I": "à¦“",
//     "J": "à¦”",
//     "K": "à¦•",
//     "L": "à¦–",
//     "M": "à¦—",
//     "N": "à¦˜",
//     "O": "à¦™",
//     "P": "à¦š",
//     "Q": "à¦›",
//     "R": "à¦œ",
//     "S": "à¦",
//     "T": "à¦ž",
//     "U": "à¦Ÿ",
//     "V": "à¦ ",
//     "W": "à¦¡",
//     "X": "à¦¢",
//     "Y": "à¦£",
//     "Z": "à¦¤",
//     "_": "à¦¥",
//     "`": "à¦¦",
//     "a": "à¦§",
//     "b": "à¦¨",
//     "c": "à¦ª",
//     "d": "à¦«",
//     "e": "à¦¬",
//     "f": "à¦­",
//     "g": "à¦®",
//     "h": "à¦¯",
//     "i": "à¦°",
//     "j": "à¦²",
//     "k": "à¦¶",
//     "l": "à¦·",
//     "m": "à¦¸",
//     "n": "à¦¹",
//     "o": "à§œ",
//     "p": "à§",
//     "q": "à§Ÿ",
//     "r": "à§Ž",
//     "0": "à§¦",
//     "1": "à§§",
//     "2": "à§¨",
//     "3": "à§©",
//     "4": "à§ª",
//     "5": "à§«",
//     "6": "à§¬",
//     "7": "à§­",
//     "8": "à§®",
//     "9": "à§¯",
//     "v": "à¦¾",
//     "w": "à¦¿",
//     "x": "à§€",
//     "y": "à§",
//     "z": "à§",
//     "~": "à§‚",
//     "â€ž": "à§ƒ",
//     "â€¡": "à§‡",
//     "â€ ": "à§‡",
//     "â€°": "à§ˆ",
//     "\\Ë†": "à§ˆ",
//     "Å ": "à§—",
//     "Ã”": "â€˜",
//     "Ã•": "â€™",
//     "\\|": "à¥¤",
//     "Ã’": "â€œ",
//     "Ã“": "â€",
//     "s": "à¦‚",
//     "t": "à¦ƒ",
//     "u": "à¦",
//     "Âª": "à§à¦°",
//     "Ã–": "à§à¦°",
//     "Â«": "à§à¦°",
//     "Â¨": "à§à¦¯",
//     "\\&": "à§",
//     "â€¦": "à§ƒ",
//     "à¦¶Â¦": "à¦¶à§à¦¬",
//     "à¦¬à§à¦°Ã¦": "à¦¬à§à¦°à§",
//     "à¦—à§à¦°Ã¦": "à¦—à§à¦°à§",
//     "Ã‘": "-",
//     "Ã‘": "-",
//     "à¦¶^": "à¦¶à§à¦¬",
//     "YÅ“": "à¦£à§à¦¨",
//     "YÅ“": "à¦£à§à¦¨",
//     "à¦£Å“": "à¦£à§à¦¨",
//     "à¦£Å“": "à¦£à§à¦¨",
//     "à¦¤à§à¦¤Â¡": "à¦¤à§à¦¤à§à¦¬",
//     "à¦¤à§à¦¤Â¡": "à¦¤à§à¦¤à§à¦¬",
//     "â€š": " à§‚",
//     "â€š": "à§‚",
// };


// function ReArrangeUniToBijoy(str) {
//     for (var i = 0; i < str.length; i++) {
//         if (i > 0 && str.charAt(i) == '\u09CD' && (IsBanglaKar1(str.charAt(i - 1)) || IsBanglaNukta1(str.charAt(i - 1))) && i < str.length - 1) {
//             var temp = str.substring(0, i - 1);
//             temp += str.charAt(i);
//             temp += str.charAt(i + 1);
//             temp += str.charAt(i - 1);
//             temp += str.substring(i + 2, str.length);
//             str = temp;
//         }
//         if (i > 0 && i < str.length - 1 && str.charAt(i) == '\u09CD' && str.charAt(i - 1) == '\u09B0' && str.charAt(i - 2) != '\u09CD' && IsBanglaKar1(str.charAt(i + 1))) {
//             var temp = str.substring(0, i - 1);
//             temp += str.charAt(i + 1);
//             temp += str.charAt(i - 1);
//             temp += str.charAt(i);
//             temp += str.substring(i + 2, str.length);
//             str = temp;
//         }
//         if (i < str.length - 1 && str.charAt(i) == 'à¦°' && IsBanglaHalant1(str.charAt(i + 1)) && !IsBanglaHalant1(str.charAt(i - 1))) {
//             var j = 1;
//             while (true) {
//                 if (i - j < 0)
//                     break;
//                 if (IsBanglaBanjonborno1(str.charAt(i - j)) && IsBanglaHalant1(str.charAt(i - j - 1)))
//                     j += 2;
//                 else if (j == 1 && IsBanglaKar1(str.charAt(i - j)))
//                     j++;
//                 else
//                     break;
//             }
//             var temp = str.substring(0, i - j);
//             temp += str.charAt(i);
//             temp += str.charAt(i + 1);
//             temp += str.substring(i - j, i);
//             temp += str.substring(i + 2, str.length);
//             str = temp;
//             i += 1;
//             continue;
//         }
//         if (i < str.length - 1 && IsBanglaPreKar1(str.charAt(i)) && IsSpace1(str.charAt(i + 1)) == false) {
//             var temp = str.substring(0, i);
//             var j = 1;
//             while (IsBanglaBanjonborno1(str.charAt(i + j))) {
//                 if (IsBanglaHalant1(str.charAt(i + j + 1)))
//                     j += 2;
//                 else
//                     break;
//             }
//             temp += str.substring(i + 1, i + j + 1);
//             var l = 0;
//             if (str.charAt(i) == 'à§‡' && str.charAt(i + j + 1) == 'à¦¾') {
//                 temp += "à§‹";
//                 l = 1;
//             } else if (str.charAt(i) == 'à§‡' && str.charAt(i + j + 1) == "à§—") {
//                 temp += "à§Œ";
//                 l = 1;
//             } else
//                 temp += str.charAt(i);
//             temp += str.substring(i + j + l + 1, str.length);
//             str = temp;
//             i += j;
//         }
//         if (i < str.length - 1 && str.charAt(i) == 'à¦' && IsBanglaPostKar1(str.charAt(i + 1))) {
//             var temp = str.substring(0, i);
//             temp += str.charAt(i + 1);
//             temp += str.charAt(i);
//             temp += str.substring(i + 2, str.length);
//             str = temp;
//         }
//     }
//     return str;
// }
// function ConvertToBijoy(ConvertFrom, line) {
//     var conversion_map = uni_string_conversion_map;
//     if (ConvertFrom == "uni")
//         conversion_map = uni_string_conversion_map;
//     else if (ConvertFrom == "somewherein")
//         conversion_map = somewherein_string_conversion_map;
//     else if (ConvertFrom == "boisakhi")
//         conversion_map = boisakhi_string_conversion_map;
//     for (var ascii in conversion_map) {
//         var myRegExp = new RegExp(ascii,"g");
//         line = line.replace(myRegExp, conversion_map[ascii]);
//     }
//     line = ReArrangeUniToBijoy(line);
//     var myRegExp = new RegExp("à¦…à¦¾","g");
//     line = line.replace(myRegExp, "à¦†");
//     return line;
// }




// function Insert(field, text) {
//     field.value =text;
//     /* if (document.selection)
//      { field.focus(); sel = document.selection.createRange(); sel.text = text; sel.collapse(true); sel.select(); }
//      else if (field.selectionStart || field.selectionStart == '0')
//      { var startPos = field.selectionStart; var endPos = field.selectionEnd; var scrollTop = field.scrollTop; startPos = (startPos == -1 ? field.value.length : startPos); field.value = field.value.substring(0, startPos) + text + field.value.substring(endPos, field.value.length); field.focus(); field.selectionStart = startPos + text.length; field.selectionEnd = startPos + text.length; field.scrollTop = scrollTop; }
//      else
//      { var scrollTop = field.scrollTop; field.value += value; field.focus(); field.scrollTop = scrollTop; }*/
// }
// function RemoveNInsert(field, value, len) {
//     if (document.selection) {
//         field.focus(); sel = document.selection.createRange(); if (field.value.length >= len)
//         { sel.moveStart('character', -1 * (len)); }
//         sel.text = value; sel.collapse(true); sel.select();
//     }
//     else if (field.selectionStart || field.selectionStart == 0) { field.focus(); var startPos = field.selectionStart - len; var endPos = field.selectionEnd; var scrollTop = field.scrollTop; startPos = (startPos == -1 ? field.value.length : startPos); field.value = field.value.substring(0, startPos) + value + field.value.substring(endPos, field.value.length); field.focus(); field.selectionStart = startPos + value.length; field.selectionEnd = startPos + value.length; field.scrollTop = scrollTop; } else { var scrollTop = field.scrollTop; field.value += value; field.focus(); field.scrollTop = scrollTop; }
// }
// function capsDetect(e)
// { if (!e) e = window.event; if (!e) return false; var theKey = e.which ? e.which : (e.keyCode ? e.keyCode : (e.charCode ? e.charCode : 0)); var theShift = e.shiftKey || (e.modifiers && (e.modifiers & 4)); return ((theKey > 64 && theKey < 91 && !theShift) || (theKey > 96 && theKey < 123 && theShift)); }
// function HideDIV(id) {
//     if (document.getElementById) { document.getElementById(id).style.display = 'none'; }
//     else {
//         if (document.layers) { document.id.display = 'none'; }
//         else { document.all.id.style.display = 'none'; }
//     }
// }
// function ShowDIV(id) {
//     if (document.getElementById) { document.getElementById(id).style.display = 'block'; }
//     else {
//         if (document.layers) { document.id.display = 'block'; }
//         else { document.all.id.style.display = 'block'; }
//     }
// }
// function IsBanglaDigit1(CUni) {
//     if (CUni == 'à§¦' || CUni == 'à§§' || CUni == 'à§¨' || CUni == 'à§©' || CUni == 'à§ª' || CUni == 'à§«' || CUni == 'à§¬' || CUni == 'à§­' || CUni == 'à§®' || CUni == 'à§¯')
//         return true; return false;
// }
// function IsBanglaPreKar1(CUni) {
//     if (CUni == 'à¦¿' || CUni == 'à§ˆ' || CUni == 'à§‡')
//         return true; return false;
// }
// function IsBanglaPostKar1(CUni) {
//     if (CUni == 'à¦¾' || CUni == 'à§‹' || CUni == 'à§Œ' || CUni == 'à§—' || CUni == 'à§' || CUni == 'à§‚' || CUni == 'à§€' || CUni == 'à§ƒ')
//         return true; return false;
// }
// function IsBanglaKar1(CUni) {
//     if (IsBanglaPreKar1(CUni) || IsBanglaPostKar1(CUni))
//         return true; return false;
// }
// function IsBanglaBanjonborno1(CUni) {
//     if (CUni == 'à¦•' || CUni == 'à¦–' || CUni == 'à¦—' || CUni == 'à¦˜' || CUni == 'à¦™' || CUni == 'à¦š' || CUni == 'à¦›' || CUni == 'à¦œ' || CUni == 'à¦' || CUni == 'à¦ž' || CUni == 'à¦Ÿ' || CUni == 'à¦ ' || CUni == 'à¦¡' || CUni == 'à¦¢' || CUni == 'à¦£' || CUni == 'à¦¤' || CUni == 'à¦¥' || CUni == 'à¦¦' || CUni == 'à¦§' || CUni == 'à¦¨' || CUni == 'à¦ª' || CUni == 'à¦«' || CUni == 'à¦¬' || CUni == 'à¦­' || CUni == 'à¦®' || CUni == 'à¦¶' || CUni == 'à¦·' || CUni == 'à¦¸' || CUni == 'à¦¹' || CUni == 'à¦¯' || CUni == 'à¦°' || CUni == 'à¦²' || CUni == 'à§Ÿ' || CUni == 'à¦‚' || CUni == 'à¦ƒ' || CUni == 'à¦' || CUni == 'à§Ž')
//         return true; return false;
// }
// function IsBanglaSoroborno1(CUni) {
//     if (CUni == 'à¦…' || CUni == 'à¦†' || CUni == 'à¦‡' || CUni == 'à¦ˆ' || CUni == 'à¦‰' || CUni == 'à¦Š' || CUni == 'à¦‹' || CUni == 'à¦Œ' || CUni == 'à¦' || CUni == 'à¦' || CUni == 'à¦“' || CUni == 'à¦”')
//         return true; return false;
// }
// function IsBanglaNukta1(CUni) {
//     if (CUni == 'à¦‚' || CUni == 'à¦ƒ' || CUni == 'à¦')
//         return true; return false;
// }
// function IsBanglaFola1(CUni) {
//     if (CUni == "à§à¦¯" || CUni == "à§à¦°")
//         return true; return false;
// }
// function IsBanglaHalant1(CUni) {
//     if (CUni == 'à§')
//         return true; return false;
// }
// function IsSpace1(C) {
//     if (C == ' ' || C == '\t' || C == '\n' || C == '\r')
//         return true; return false;
// }
// function MapKarToSorborno1(CUni) {
//     var CSorborno = CUni; if (CUni == 'à¦¾')
//         CSorborno = 'à¦†'; else if (CUni == 'à¦¿')
//         CSorborno = 'à¦‡'; else if (CUni == 'à§€')
//         CSorborno = 'à¦ˆ'; else if (CUni == 'à§')
//         CSorborno = 'à¦‰'; else if (CUni == 'à§‚')
//         CSorborno = 'à¦Š'; else if (CUni == 'à§ƒ')
//         CSorborno = 'à¦‹'; else if (CUni == 'à§‡')
//         CSorborno = 'à¦'; else if (CUni == 'à§ˆ')
//         CSorborno = 'à¦'; else if (CUni == 'à§‹')
//         CSorborno = 'à¦“'; else if (CUni == "à§‡à¦¾")
//         CSorborno = 'à¦“'; else if (CUni == 'à§Œ')
//         CSorborno = 'à¦”'; else if (CUni == "à§‡à§—")
//         CSorborno = 'à¦”'; return CSorborno;
// }
// function MapSorbornoToKar1(CUni) {
//     var CKar = CUni; if (CUni == 'à¦†')
//         CKar = 'à¦¾'; else if (CUni == 'à¦‡')
//         CKar = 'à¦¿'; else if (CUni == 'à¦ˆ')
//         CKar = 'à§€'; else if (CUni == 'à¦‰')
//         CKar = 'à§'; else if (CUni == 'à¦Š')
//         CKar = 'à§‚'; else if (CUni == 'à¦‹')
//         CKar = 'à§ƒ'; else if (CUni == 'à¦')
//         CKar = 'à§‡'; else if (CUni == 'à¦')
//         CKar = 'à§ˆ'; else if (CUni == 'à¦“')
//         CKar = 'à§‹'; else if (CUni == 'à¦”')
//         CKar = 'à§Œ'; return CKar;
// }


var uni2bijoy_string_conversion_map = {
	"প্র": "cÖ",
    'স্ত': '¯Í',
    "।": "|",
    "‘": "Ô",
    "’": "Õ",
    "“": "Ò",
    "”": "Ó",
    "্র্য": "ª¨",
    "র‌্য": "i¨",
    "ক্ক": "°",
    "ক্ট": "±",
    "ক্ত": "³",
    "ক্ব": "K¡",
    "স্ক্র": "¯Œ",
    "ক্র": "µ",
    "ক্ল": "K¬",
    "ক্ষ": "¶",
    "ক্স": "·",
    "গু": "¸",
    "গ্ধ": "»",
    "গ্ন": "Mœ",
    "গ্ম": "M¥",
    "গ্ল": "M­",
    "গ্রু": "Mªy",
    "ঙ্ক": "¼",
    "ঙ্ক্ষ": "•¶",
    "ঙ্খ": "•L",
    "ঙ্গ": "½",
    "ঙ্ঘ": "•N",
    "চ্চ": "”P",
    "চ্ছ": "”Q",
    "চ্ছ্ব": "”Q¡",
    "চ্ঞ": "”T",
    "জ্জ্ব": "¾¡",
    "জ্জ": "¾",
    "জ্ঝ": "À",
    "জ্ঞ": "Á",
    "জ্ব": "R¡",
    "ঞ্চ": "Â",
    "ঞ্ছ": "Ã",
    "ঞ্জ": "Ä",
    "ঞ্ঝ": "Å",
    "ট্ট": "Æ",
    "ট্ব": "U¡",
    "ট্ম": "U¥",
    "ড্ড": "Ç",
    "ণ্ট": "È",
    "ণ্ঠ": "É",
    "ন্স": "Ý",
    "ণ্ড": "Ê",
    "ন্তু": "š‘",
    "ণ্ব": "Y^",
    "ত্ত": "Ë",
    "ত্ত্ব": "Ë¡",
    "ত্থ": "Ì",
    "ত্ন": "Zœ",
    "ত্ম": "Z¥",
    "ন্ত্ব": "š—¡",
    "ত্ব": "Z¡",
    "থ্ব": "_¡",
    "দ্গ": "˜M",
    "দ্ঘ": "˜N",
    "দ্দ": "Ï",
    "দ্ধ": "×",
    "দ্ব": "˜¡",
    "দ্ব": "Ø",
    "দ্ভ": "™¢",
    "দ্ম": "Ù",
    "দ্রু": "`ª“",
    "ধ্ব": "aŸ",
    "ধ্ম": "a¥",
    "ন্ট": "›U",
    "ন্ঠ": "Ú",
    "ন্ড": "Û",
    "ন্ত্র": "š¿",
    "ন্ত": "š—",
    "স্ত্র": "¯¿",
    "ত্র": "Î",
    "ন্থ": "š’",
    "ন্দ": "›`",
    "ন্দ্ব": "›Ø",
    "ন্ধ": "Ü",
    "ন্ন": "bœ",
    "ন্ব": "š^",
    "ন্ম": "b¥",
    "প্ট": "Þ",
    "প্ত": "ß",
    "প্ন": "cœ",
    "প্প": "à",
    "প্ল": "c­",
    "প্স": "á",
    "ফ্ল": "d¬",
    "ব্জ": "â",
    "ব্দ": "ã",
    "ব্ধ": "ä",
    "ব্ব": "eŸ",
    "ব্ল": "e­",
    "ভ্র": "å",
    "ম্ন": "gœ",
    "ম্প": "¤ú",
    "ম্ফ": "ç",
    "ম্ব": "¤^",
    "ম্ভ": "¤¢",
    "ম্ভ্র": "¤£",
    "ম্ম": "¤§",
    "ম্ল": "¤­",
    "রু": "i“",
    "রূ": "iƒ",
    "ল্ক": "é",
    "ল্গ": "ê",
    "ল্প": "í",
    "ল্ট": "ë",
    "ল্ড": "ì",
    "ল্ফ": "î",
    "ল্ব": "j¦",
    "ল্ম": "j¥",
    "ল্ল": "jø",
    "শু": "ï",
    "শ্চ": "ð",
    "শ্ন": "kœ",
    "শ্ব": "k¦",
    "শ্ম": "k¥",
    "শ্ল": "kø",
    "ষ্ক": "®‹",
    "ষ্ক্র": "®Œ",
    "ষ্ট": "ó",
    "ষ্ঠ": "ô",
    "ষ্ণ": "ò",
    "ষ্প": "®ú",
    "ষ্ফ": "õ",
    "ষ্ম": "®§",
    "স্ক": "¯‹",
    "স্ট": "÷",
    "স্খ": "ö",
    "স্তু": "¯‘",
    "স্থ": "¯’",
    "স্ন": "mœ",
    "স্প": "¯ú",
    "স্ফ": "ù",
    "স্ব": "¯^",
    "স্ম": "¯§",
    "স্ল": "¯­",
    "হু": "û",
    "হ্ণ": "nè",
    "হ্ন": "ý",
    "হ্ম": "þ",
    "হ্ল": "n¬",
    "হৃ": "ü",
    "র্": "©",
    "্র": "«",
    "্য": "¨",
    "্": "&",
    "আ": "Av",
    "অ": "A",
    "ই": "B",
    "ঈ": "C",
    "উ": "D",
    "ঊ": "E",
    "ঋ": "F",
    "এ": "G",
    "ঐ": "H",
    "ও": "I",
    "ঔ": "J",
    "ক": "K",
    "খ": "L",
    "গ": "M",
    "ঘ": "N",
    "ঙ": "O",
    "চ": "P",
    "ছ": "Q",
    "জ": "R",
    "ঝ": "S",
    "ঞ": "T",
    "ট": "U",
    "ঠ": "V",
    "ড": "W",
    "ঢ": "X",
    "ণ": "Y",
    "ত": "Z",
    "থ": "_",
    "দ": "`",
    "ধ": "a",
    "ন": "b",
    "প": "c",
    "ফ": "d",
    "ব": "e",
    "ভ": "f",
    "ম": "g",
    "য": "h",
    "র": "i",
    "ল": "j",
    "শ": "k",
    "ষ": "l",
    "স": "m",
    "হ": "n",
    "ড়": "o",
    "ঢ়": "p",
    "য়": "q",
    "ৎ": "r",
    "০": "0",
    "১": "1",
    "২": "2",
    "৩": "3",
    "৪": "4",
    "৫": "5",
    "৬": "6",
    "৭": "7",
    "৮": "8",
    "৯": "9",
    "া": "v",
    "ি": "w",
    "ী": "x",
    "ু": "y",
    "ূ": "~",
    "ৃ": "…",
    "ে": "‡",
    "ৈ": "‰",
    "ৗ": "Š",
    "ং": "s",
    "ঃ": "t",
    "ঁ": "u",
};

function ReArrangeUnicodeText(str) {
    var barrier = 0;
    for (var i = 0; i < str.length; i++) {
        if (i < str.length && IsBanglaPreKar(str.charAt(i))) {
            var j = 1;
            while (IsBanglaBanjonborno(str.charAt(i - j))) {
                if (i - j < 0)
                    break;
                if (i - j <= barrier)
                    break;
                if (IsBanglaHalant(str.charAt(i - j - 1)))
                    j += 2;
                else
                    break;
            }
            var temp = str.substring(0, i - j);
            temp += str.charAt(i);
            temp += str.substring(i - j, i);
            temp += str.substring(i + 1, str.length);
            str = temp;
            barrier = i + 1;
            continue;
        }
        if (i < str.length - 1 && IsBanglaHalant(str.charAt(i)) && str.charAt(i - 1) == 'র' && !IsBanglaHalant(str.charAt(i - 2))) {
            var j = 1;
            var found_pre_kar = 0;
            while (true) {
                if (IsBanglaBanjonborno(str.charAt(i + j)) && IsBanglaHalant(str.charAt(i + j + 1)))
                    j += 2;
                else if (IsBanglaBanjonborno(str.charAt(i + j)) && IsBanglaPreKar(str.charAt(i + j + 1))) {
                    found_pre_kar = 1;
                    break;
                } else
                    break;
            }
            var temp = str.substring(0, i - 1);
            temp += str.substring(i + j + 1, i + j + found_pre_kar + 1);
            temp += str.substring(i + 1, i + j + 1);
            temp += str.charAt(i - 1);
            temp += str.charAt(i);
            temp += str.substring(i + j + found_pre_kar + 1, str.length);
            str = temp;
            i += (j + found_pre_kar);
            barrier = i + 1;
            continue;
        }
    }
    return str;
}
function ConvertToASCII(ConvertTo, line) {
    var conversion_map = uni2bijoy_string_conversion_map;
    if (ConvertTo == "bijoy")
        conversion_map = uni2bijoy_string_conversion_map;
    var myRegExp;
    myRegExp = new RegExp("ো","g");
    line = line.replace(myRegExp, "ো");
    myRegExp = new RegExp("ৌ","g");
    line = line.replace(myRegExp, "ৌ");
    line = ReArrangeUnicodeText(line);
    for (var unic in conversion_map) {
        myRegExp = new RegExp(unic,"g");
        line = line.replace(myRegExp, conversion_map[unic]);
    }
    return line;
}


function ConvertUniToBijoy(text) {
    var newtext = ConvertToASCII("bijoy", text);
    return newtext;
}
