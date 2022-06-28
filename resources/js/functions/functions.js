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

export { last };
