# Free Note

## Purpose

- record notes freely
  * formats
    * plain text
    * also rich text 
    * especially codes for programers
  * automatic saving - don't worry about losing content
    * auto saving to local / browser
    * saving to the browser's IndexedDB
    * history
  
- store notes freely with open API
  * on the cloud
  * or on the PC/browser
  
- search notes freely
  * search everything in the notes
  
- security
  * safe login/register
  * safe notes access
  * everything in the notes are secrets
- share
  * share some notes(mirror) to friends
  
## Architecture
  Basicly, server and client two systems will cooperate:
- server provides the note service:
  * authenticate
    * register
    * login
    * logout
  * folder
    * create
    * delete
    * rename
    * alter order
    * alter parent
  * note
    * create
    * delete
    * update
    * update history ~~
  * attachment (for what cannot embled into the note)
    * upload (create)
    * delete
  * search
    * conditions: note name, folder name, create time, last update time
    * search in history ~~
  * DB
    * use MySQL
    * use filesystem??
    * use MongoDB??
- client provides the user interface:
  * single page APP(no refreshing whole page)
  * mobile browser is also compatible
  * folder: tree view
  * note: 
    * block tumblenail
    * view mode
    * edit mode
  * note editor:
    * open to any editor
    * TinyMCE
    * Markdown editor..
  * auto saving to browser's indexedDB
  * offline mode
    * sync from the server
    * sync to the server
    * detect and resolve conflicts
    * avoid concurent editing??
  * ...
  
  
