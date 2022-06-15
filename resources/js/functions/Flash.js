import Message from 'vue-m-message';

/**
 * Fonction permet de génerer un message flash
 *
 * @param   {String}  type          Type de message (success, error)
 * @param   {String}  title         Titre du message
 * @param   {String}  message       Contenu du message
 * @param   {String}  position      Position du message (bottom-right, ...)
 *
 * @return  {Message}                Fonction qui génere le message flash
 */
export default function Flash(type, title, message, position = 'bottom-right') {
    return Message({
        type: type,
        title: title,
        message: message,
        position: position,
        duration: 5000,
        width: "25%",
        className: `message-${type} p-3`,
        stopTimerOnHover: true,
        closable: true,
    })
}
