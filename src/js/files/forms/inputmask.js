/* Маски для полей (в работе) */

// Подключение функционала 
// Подключение списка активных модулей
import { flsModules } from "../modules.js";

// Подключение модуля
import "inputmask/dist/inputmask.min.js";

const inputMasks = document.querySelectorAll('.wpcf7-validates-as-tel');
if (inputMasks.length) {
	flsModules.inputmask = Inputmask("+7  999 999 99 99", {showMaskOnHover: false}).mask(inputMasks);
}