window.ucfirst = (string) => {
    string = string.replaceAll('matiere', 'matière').replaceAll('premiere', 'prémière')
    return string.charAt(0).toUpperCase() + string.slice(1)
}
