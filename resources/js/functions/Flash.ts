import Message from 'vue-m-message';

/**
 * Fonction permet de génerer un message flash
 *
 * @param   {String}  type          Type de message (success, error)
 * @param   {String}  title         Titre du message
 * @param   {String}  message       Contenu du message
 * @param   {Number}  delay         Nombre de seconde pour afficher le popup
 * @param   {Boolean} closable      Determiner si le popup est closable
 * @param   {String}  position      Position du message (bottom-right, ...)
 *
 * @return  {Message}                Fonction qui génere le message flash
 */
export default function Flash(type: string, title: string, message: string, delay: number = 5, closable: Boolean = true, position: string = 'bottom-right') {
    return Message({
        /*type: type,
        title: title,
        message: message,
        position: position,
        duration: 1000 * delay,
        width: "25%",
        className: `message-${type} p-3`,
        stopTimerOnHover: true,
        closable: closable,*/
    })
}
