// index html
/* 
  1. グローバル変数
  */
const db = firebase.firestore();
// グローバル変数の宣言
let loginUser = "";
const username = document.getElementById("username");
const postarea = document.getElementById("post-area"); 
const chathistory = document.getElementById('chat-history');
const meetingdate = document.getElementById('meetingdate');

let today = new Date();
let createdDate = "";
let todoMessage = "";
let agendaMessage = "";
let conclusionMessage = "";

/* 
  2. イベントリスナー
*/

// A. 画面読み込み時
//firebaseのデーターベース（保存させる場所）を使いますよ
let newPostRef = firebase.database().ref();
// ユーザー情報の取得と表示
initialProcess();

// 関数の呼び出し
function initialProcess(){
  //ユーザーの読み込み
  showUserName();
  //初期値で今日の日付を議事録にセットする
  setInitialDate();
  // ノードを新規作成するか判断させる
  // judgeCreateChild();
}

/* 
 Firebaseのイベントリスナー child_added
 */

// Chatが投稿された時のイベント監視
    newPostRef.child(createdDate).child('message').on("child_added", function (data) {
    writeChatData(data);
  })

    //ToDoエリアへの書き込みイベント
    newPostRef.child(createdDate).child('todo').on("child_added", function (data) {
      writeToDoData(data);
    })

    // Agendaエリアへの書き込みイベント
    newPostRef.child(createdDate).child('agenda').on("child_added", function (data) {
      writeAgendaData(data);
    })
    // Decisionエリアへの書き込みイベント
    newPostRef.child(createdDate).child('decision').on("child_added", function (data) {
      writeDecisionData(data);
    })

/* 
      3.ボタンがクリックされた時のアクション
*/

// Dateが変更された時のイベント
meetingdate.addEventListener("change",function(e){
  //変更された日付を取得
  let day =  e.target.value;
  createdDate = day.replaceAll("-","/");
  console.log(createdDate);
  showChatHistory(createdDate);
  // 今日じゃなければ投稿欄を表示しない
  if(day !== today){
    postarea.classList.add("hidden");
  } else{
    postarea.classList.remove("hidden");
  }
} );



// チャットエリアの処理
    // 送信ボタンをクリックされたら次の処理をする
    $("#send").on("click", function () {
      sendPosts();
    });

  // チャット欄でEnterキーを押した時にも投稿できるようにする

  $("#message").on("keydown", function (e) {
    if(e.keyCode === 13){
      sendPosts();
  }
  });

// チャットへのアクション

  // Agendaリンクのクリック
  // $("#chat-history").on('click', '.agendabtn', function (e) { 
  //   e.preventDefault();
  //   console.log(`Click Agenda Btn`);
  //   agendaMessage = this.getAttribute('href');   
  //   // FirebaseのAgendaに書き込む
  //   console.log(`agenda:${agendaMessage}`);
  //   // sendAgenda();        
  // });


  // Chat Naviボタンのクリック
// $("#chat-history").off().on('click', '.todobtn', function (e) { 
      chathistory.addEventListener("click", function(e){
      e.preventDefault();
      // todoボタンを押したらtodoとしてデータを書き込む
      if (e.target && e.target.matches("a.todobtn")){
        // console.log("click todo btn");
        todoMessage = e.target.dataset.a;
        sendToDo(todoMessage);        
      }  
      // Agendaボタンを押したらagendaとしてデータを書き込む
      if (e.target && e.target.matches("a.agendabtn")){
        console.log("click agenda btn");
        agendaMessage = e.target.dataset.a;
        sendAgenda(agendaMessage);        
      }  
      // Decisionボタンを押したらdecisionとしてデータを書き込む
      if (e.target && e.target.matches("a.decisionbtn")){
        console.log("click decision btn");
        decisionMessage = e.target.dataset.a;
        sendDecision(decisionMessage);        
      }  
    });
  

//*   
//  4.関数
//            */


// 日付が変更した時のその日のデータを読み込み直す
    function showChatHistory(d){
      // 履歴をクリアする
      $("#chat-history").empty();
      $("#agendalist").empty();
      $("#todolist").empty();
      $("#decisionlist").empty();

      // 過去の日付のデータを取得して書き込む
      newPostRef.child(d).once('value').then((snapshot) => {
        if (snapshot.exists()){
          // チャットの書き込み
          snapshot.child('message').forEach((childSnapshot)=>{
            writeChatData(childSnapshot);
          })
          // Agenda書き込み
          snapshot.child('agenda').forEach((childSnapshot)=>{
            writeAgendaData(childSnapshot);
          })
          // ToDo書き込み
          snapshot.child('todo').forEach((childSnapshot)=>{
            writeToDoData(childSnapshot);
          })
          snapshot.child('decision').forEach((childSnapshot)=>{
            writeDecisionData(childSnapshot);
          })
          //  writeToDoData(childSnapshot);
        } else {
          alert("no data available!");
        }
      }).catch((error) => {
        console.log(error)
      });
    }
    
    // function setCreatedDate(){
    //     const date = document.getElementById("createdate");
    //     date.innerText = `作成日: ${createdDate}`; 
    // }

// チャットデータの送信
  function sendPosts(){
      let today = new Date();
      //データの格納
      // 空白だったら送らない
      const m =$('#message').val();
      if(m !== ""){
        newPostRef.child(createdDate).child('message').push({
            postTime: `${today.toLocaleString()}`,
            username: `${loginUser}`,
            text:`${m}`,
          })
        //   チャットスペースをクリアする
        $('#message')
             .val("").focus();
      } else {
        alert("Enter your message!");
      }
  }
    
// ToDoのデータをFireBaseに送信
function sendToDo(a){
  // console.log(`db:${todoMessage}`);
  newPostRef.child(createdDate).child('todo').push({
    todo:`${a}`,  
  })
}

// Agendaをデータに格納する
function sendAgenda(a){
  newPostRef.child(createdDate).child('agenda').push({
  agenda:`${a}`,  
})
}

  // Decisionをデータに格納する
  function sendDecision(a){
    newPostRef.child(createdDate).child('decision').push({
    decision:`${a}`,  
  })
  }

  // function setTitle(){
  //   const title = document.getElementById('theme');
  //   // タイトルがnull
  //   if (title === null){
  //     alert(`タイトルが入力されていません`);
  //   } else{
  //     // タイトルをDBに登録する
  //     sendTitle();
  //   }
// }

// ログインユーザーの表示
function showUserName(){
  firebase.auth().onAuthStateChanged( (user) => {
      if(user) {
      //   loginUser = `${user.displayName}`; 
        loginUser = user.displayName;
        username.innerHTML = `${loginUser}さん`;
        // postuser.innerHTML =  `${loginUser}`;
      }
      else {
        username.innerText = 'Not Login';
      }
    });
}

//日付をセットするための関数
function setInitialDate(){
  let inityear = today.getFullYear(); 
  let initmonth = ("0"+(today.getMonth()+1)).slice(-2);
  let initday = ("0"+(today.getDate())).slice(-2);
  // 日付を書き換える
  meetingdate.value = `${inityear}-${initmonth}-${initday}`; 
  createdDate = `${inityear}/${initmonth}/${initday}`
  today = meetingdate.value;
  }

  //チャットエリアにチャットを書き込む
function writeChatData(data){
  let v = data.val();
  let k = data.key;
    // console.log(k,v);
  // チャット欄のナビメニューを生成する
  let menu = 
  `<nav class = "chatnavi">
  <a class= 'agendabtn' href = "#" data-a ="${v.text}" >agenda</a>
  <a class= 'todobtn' href= "#" data-a = "${v.text}" >todo</a>
  <a class= 'decisionbtn' href= "#" data-a = "${v.text}" >decision</a>
  </nav>`;
  // チャットをポストする
  let str =
     `<li class="chat-data"><div>${v.username} 
     <p class ="postdate" >${v.postTime}</p><br>
     <p class = "message">${v.text}</p></div>
     ${menu}`; 
    // console.log(str);
  $("#chat-history").append(str);
} 

//TODOエリアに書き込む
function writeToDoData(data){
  let v = data.val();
  let k = data.key;
  // console.log(`${v.task}`);
  let str =
     `<li>${v.todo}</li>`; 
  // console.log(str);
  $("#todolist").append(str);
}

// Agendaに書き込む
function writeAgendaData(data){
  let v = data.val();
  let k = data.key;
  let str =
     `<li>${v.agenda}</li>`; 
  // console.log(str);
  $("#agendalist").append(str);
}

function writeDecisionData(data) {
  let v = data.val();
  let k = data.key;
  let str =
     `<li><p class = "hidden">${k}</p>${v.decision}</li>`; 
  // console.log(str);
  $("#decisionlist").append(str);
  }