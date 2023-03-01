import './date.extension';

/**
 * Recuperer le dernier element d'un tableau
 *
 * @param   {array}  array  Tableau contenant l'element
 *
 * @return  {any}         Dernier element du tableau
 */
const last = (array: Array<any>): any => {
    if (array.length === 0) return null
    return array[array.length - 1];
}


/**
 * [formatDate description]
 *
 * @param   {String|Date}  date  Date a formatter
 * @param   {Boolean}   withTime    Permet de determiner si on veut l'heure
 * @param   {Boolean}   long    Si on veut une formattage longue
 * @return  {String}        Date formatté
 */
const formatDate = (date: string | Date, withTime: boolean = true, long: boolean = true): string => {
    if (date === undefined) throw new Error("La dae a formatter n'est pas définie")
    const locale = 'fr-MG'

    const dateConfig = { weekday: "long", year: "numeric", month: "long", day: "2-digit" }
    const timeConfig = { hour: "2-digit", minute: "2-digit", second: "2-digit" }

    let config = new Object(dateConfig)
    if (withTime) config = { ...config, ...timeConfig }

    if (long === false) config = { day: "2-digit", month: "2-digit", year: "numeric" }

    let dateString: string | null = null

    if (date instanceof Date) dateString = date.toLocaleDateString(locale, config)
    else dateString = new Date(date).toLocaleDateString(locale, config)

    return ucfirst(dateString)
}


/**
 * Permet de calculer la date d'expiration d'un devis en fonction de la date de début et la validité
 *
 * @param   {String|Date}  dateDebut    La date du devis
 * @param   {Number}  delais     Nombre de jours de validité
 *
 * @return  {Date}             La date d'expiration
 */
const expiration = (dateDebut: string | Date, delais: number): Date => {
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
const ucfirst = (string: string): string => {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


/**
 * Mettre chaque debut de caractère en majuscule
 *
 * @param   {String}    string Chaine de  caractère a convertir
 * @return  {String}    Chaine de caractère modifié
 */
const ucwords = (string: string): string => {
    return string.replace(/(?:^|\s)\S/g, function (a) { return a.toUpperCase(); });
};


/**
 * [totalHT description]
 *
 * @param   {Array}  articles
 *
 * @return  {Number}
 */
const totalHT = (articles: Array<any>): number => {
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
const totalTVA = (articles: Array<any>): number => {
    let montant = 0
    articles.forEach(article => {
        montant = montant + montantTVA(article)
    })
    return montant
}


const montantHT = (article: { pivot: { pu: number; quantite: number; }; }) => {
    return article.pivot.pu * article.pivot.quantite
}

const montantTVA = (article: { pivot: { pu: number; quantite: number; tva: number; }; }) => {
    return article.pivot.pu * article.pivot.quantite * article.pivot.tva / 100
}

const montantTTC = (article: { pivot: { pu: number; quantite: number; tva: number } | { pu: number; quantite: number; tva: number; }; }) => {
    return montantTVA(article) + montantHT(article)
}


/**
 * [totalHT description]
 *
 * @param   {Array}  articles
 *
 * @return  {Number}
 */
const totalTTC = (articles: Array<any>): number => {
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
const format = (number: number, format: string = "fr-FR", options = { decimal: 2, currency: "MGA", style: "currency" }): string => {
    const locale = Intl.NumberFormat(format, options)
    return locale.format(number).replace("MGA", "Ar").replace('Ar', 'EUR');
}

/**
 * Permet de savoir le mode de livraison de la marchandises
 *
 * @param   {number}  index  Index qui correspond au mode de livraison dans le tableau ci-dessous
 * @return  {string}         La mode de livraison correspondant
 */
const modeLivraison = (index: number): string => {
    const modes = {
        1: 'Le fournisseur qui livre',
        2: 'Le client qui le recupère chez fournisseur'
    }
    return modes[index];
}


/**
 * Permet de recuperer textuellement la personne en charges de la mode de livraison
 *
 * @param   {number}  index  Index qui correspond au personnes dans la table
 * @return  {string}         Personne responsable sous forme de texte
 */
const chargeLivraison = (index: number): string => {
    const chargeurs = {
        0: 'Aucun',
        1: 'Fournisseur',
        2: 'Client'
    }

    return chargeurs[index]
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
    modeLivraison,
    chargeLivraison,
};
