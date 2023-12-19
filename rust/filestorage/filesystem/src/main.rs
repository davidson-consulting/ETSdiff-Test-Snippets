use axum::{
    body::Body, //{Body, StreamBody},
    extract::{Multipart, Path},
    http::StatusCode,
    response::{IntoResponse, Response},
    routing::{delete, get, post},
    Router,
};
use std::fs::File;
use std::io::prelude::*;
use tokio_util::io::ReaderStream;
use uuid;

#[tokio::main]
async fn main() {
    let app = Router::new()
        .route("/", get(root))
        .route("/files", post(upload))
        .route("/files/*id", get(get_file))
        .route("/files/*id", delete(del_file));

    let listener = tokio::net::TcpListener::bind("0.0.0.0:8080").await.unwrap();
    axum::serve(listener, app).await.unwrap();
}

async fn root() -> impl IntoResponse {
    Response::builder()
        .status(StatusCode::OK)
        .header("content-type", "text/plain")
        .body(Body::from("Filesystem services\n".to_string()))
        .unwrap()
}

async fn upload(mut multipart: Multipart) -> impl IntoResponse {
    while let Some(field) = multipart.next_field().await.unwrap() {
        if field.name().unwrap().to_string() == "file" {
            let data = field.bytes().await.unwrap();
            let id = uuid::Uuid::new_v4().to_string();

            let mut file = File::create(format!("/tmp/{id}")).unwrap();
            file.write_all(&data).unwrap();

            return Response::builder()
                .status(StatusCode::CREATED)
                .header("content-type", "text/plain")
                .body(Body::from(id))
                .unwrap();
        }
    }

    Response::builder()
        .status(StatusCode::BAD_REQUEST)
        .header("content-type", "text/plain")
        .body(Body::from("Must have 'file' field\n".to_string()))
        .unwrap()
}

async fn get_file(Path(id): Path<String>) -> impl IntoResponse {
    let file = match tokio::fs::File::open(format!("/tmp/{id}")).await {
        Ok(file) => file,
        Err(err) => {
            return Response::builder()
                .status(StatusCode::NOT_FOUND)
                .header("content-type", "text/plain")
                .body(Body::from(format!("File {id} not found: {}\n", err)))
                .unwrap()
        }
    };

    Response::builder()
        .status(StatusCode::OK)
        .header("content-type", "application/x-binary")
        .body(Body::from_stream(ReaderStream::new(file)))
        .unwrap()
}

async fn del_file(Path(id): Path<String>) -> impl IntoResponse {
    match tokio::fs::remove_file(format!("/tmp/{id}")).await {
        Ok(_) => Response::builder()
            .status(StatusCode::OK)
            .header("content-type", "test/plain")
            .body(Body::from(format!("file '{id}' deleted\n")))
            .unwrap(),
        Err(err) => Response::builder()
            .status(StatusCode::NOT_FOUND)
            .header("content-type", "text/plain")
            .body(Body::from(format!("File {id} not found: {err}\n")))
            .unwrap(),
    }
}
