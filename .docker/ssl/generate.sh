#! /usr/bin/env bash
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

openssl req -x509 -nodes -days 365 \
  -subj "/C=CA/ST=QC/O=Company, Inc./CN=$1" \
  -addext "subjectAltName=DNS:$1" \
  -newkey rsa:2048 \
  -keyout ${SCRIPT_DIR}/nginx-selfsigned.key \
  -out ${SCRIPT_DIR}/nginx-selfsigned.crt