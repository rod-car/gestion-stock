/**
 * Recuperer le dernier element d'un tableau
 *
 * @param   {array}  array  Tableau contenant l'element
 *
 * @return  {any}         Dernier element du tableau
 */
const last = (array) => {

    if (array.length === 0) return null

    return array[array.length - 1];

}


/**
 * [formatDate description]
 *
 * @param   {String|Date}  date  Date a formatter
 * @param   {Boolean}   withTime    Permet de determiner si on veut l'heure
 * @return  {String}        Date formatté
 */
const formatDate = (date, withTime = true, long = true) => {
    if (date === undefined) throw new Error("La dae a formatter n'est pas définie")
    const locale = 'fr-MG'

    const dateConfig = { weekday: "long", year: "numeric", month: "long", day: "2-digit" }
    const timeConfig = { hour: "2-digit", minute: "2-digit", second: "2-digit" }

    let config = new Object(dateConfig)
    if (withTime) config = { ...config, ...timeConfig }

    if (long === false) config = { day: "2-digit", month: "2-digit", year: "numeric" }

    let dateString = null

    if (date instanceof Date) dateString = date.toLocaleDateString(locale, config)
    else dateString = new Date(date).toLocaleDateString(locale, config)

    return ucfirst(dateString)
}


/**
 * Permet de calculer la date d'expiration d'un dévis en fonction de la date de début et la validité
 *
 * @param   {String|Date}  dateDebut    La date du dévis
 * @param   {Number}  delais     Nombre de jours de validité
 *
 * @return  {Date}             La date d'expiration
 */
const expiration = (dateDebut, delais) => {
    if (dateDebut === undefined || delais === undefined) throw new Error("La date ou le delais n'est pas définie")

    if (dateDebut instanceof Date) {
        return dateDebut.addDays(delais)
    }
    return new Date(dateDebut).addDays(delais)
}


/**
 * Mettre en majuscule la prémière lettre de la chaine de caractère
 *
 * @param   {String}    string Chaine de  caractère a convertir
 * @return  {String}    Chaine de caractère modifié
 */
const ucfirst = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


/**
 * Mettre chaque debut de caractère en majuscule
 *
 * @param   {String}    string Chaine de  caractère a convertir
 * @return  {String}    Chaine de caractère modifié
 */
const ucwords = (string) => {
    return string.replace(/(?:^|\s)\S/g, function (a) { return a.toUpperCase(); });
};


/**
 * [totalHT description]
 *
 * @param   {Array}  articles
 *
 * @return  {Number}
 */
const totalHT = (articles) => {
    let montant = 0
    articles.forEach(article => {
        montant = montant + montantHT(article)
    })
    return montant
}


/**
 * [totalHT description]
 *
 * @param   {Array}  articles
 *
 * @return  {Number}
 */
const totalTVA = (articles) => {
    let montant = 0
    articles.forEach(article => {
        montant = montant + montantTVA(article)
    })
    return montant
}


const montantHT = (article) => {
    return article.pivot.pu * article.pivot.quantite
}

const montantTVA = (article) => {
    return article.pivot.pu * article.pivot.quantite * article.pivot.tva / 100
}

const montantTTC = (article) => {
    return montantTVA(article) + montantHT(article)
}


/**
 * [totalHT description]
 *
 * @param   {Array}  articles
 *
 * @return  {Number}
 */
const totalTTC = (articles) => {
    let montant = 0
    articles.forEach(article => {
        montant = montant + montantTTC(article)
    })
    return montant
}


/**
 * Formatter un nombre aven un format internationale
 *
 * @param   {Number}    number  Nombre a formatter
 * @param   {String}    format  Format internationale de l'argent
 * @return  {String}
 */
const format = (number, format = "fr-FR", options = { decimal: 2, currency: "MGA", style: "currency" }) => {
    const locale = Intl.NumberFormat(format, options)
    return locale.format(number).replace("MGA", "Ar");
}


export {
    last,
    expiration,
    formatDate,
    ucfirst,
    ucwords,
    montantHT,
    montantTVA,
    montantTTC,
    totalHT,
    totalTVA,
    totalTTC,
    format,
};
