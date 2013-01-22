/**
 * Localization strings for the UI Multiselect widget
 *
 * @locale fr, fr-FR, fr-CA
 */

$.extend($.ui.multiselect.locale, {
	addAll:'Ajouter tout',
	removeAll:'Vider',
	itemsCount:'#{count} objets sélectionnés',
	itemsTotal:'#{count} objets total',
	busy:'veuillez patienter...',
	errorDataFormat:"Les données n'ont pas pu être ajoutés, format inconnu.",
	errorInsertNode:"Un problème est survenu en tentant d'ajouter l'item:\n\n\t[#{key}] => #{value}\n\nL'opération a été annulée.",
	errorReadonly:"L'option #{option} est en lecture seule.",
	errorRequest:"Désolé! Il semble que la requête ne se soit pas terminé correctement. (Type: #{status})"
});
